<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Catalogue as EntityParentCrud;
use App\Entity\CatalogueProduct as EntityCrud;
use App\Form\Type\Admin\CatalogueProductType as EntityFormType;

class CatalogueProductController extends AbstractController
{
    protected $entityName = 'CatalogueProduct';
    protected $entityLabel = 'Producto de Catalogo';
    protected $routeList = 'admin_catalogueproduct_list';
    protected $routeAdd = 'admin_catalogueproduct_add';
    protected $routeEdit = 'admin_catalogueproduct_edit';
    protected $routeDelete = 'admin_catalogueproduct_delete';
    protected $parameterId = 'idCatalogueProduct';

    protected $parentLabel = 'Catálogo';
    protected $parentClass = 'Catalogue';
    protected $parentParameterId = 'idCatalogue';
    protected $parentField = 'catalogue';

    /**
     * @Route("catalogo-productos/{idCatalogue}", 
     *         defaults={"idCatalogue"=null}, 
     *         requirements={"idCatalogue"="\d+"}, 
     *         name="admin_catalogueproduct_list"
     * )
     */
    public function list(Request $request, $idCatalogue = null){
        $parentParameterId = $this->parentParameterId;
        $entityParent = $this->entityParentFromId($$parentParameterId);
        $entities =  $this->getDoctrine()->getRepository(EntityCrud::class)->findBy([$this->parentField => $entityParent]);

        $table_conf = ['columns' => [
                        ['header_label' => 'Producto', 'header_alignment' => 'left', 'field' => ['product', 'name'], 'data_alignment' => 'left'], 
                        ['header_label' => 'Precio', 'header_alignment' => 'center', 'field' => 'price', 'data_alignment' => 'center']
                       ], 
                       'cardinal' => true,
                       'parent' => ['name_id' => $this->parentParameterId, 'id' => $entityParent->getId()], 
                       'new_button' => ['label' => 'Agregar ' . $this->entityLabel, 'route' =>  $this->routeAdd],
                       'actions' => [
                        'edit' => ['label' => 'Editar ' . $this->entityLabel, 
                                   'route' => $this->routeEdit, 
                                   'name_id' => $this->parameterId, 
                                   'button_class' => 'btn-success', 
                                   'icon_class' => 'fa fa-edit'
                                  ],
                        'delete' => ['label' => 'Eliminar ' . $this->entityLabel, 
                                     'route' => $this->routeDelete, 
                                     'name_id' => $this->parameterId, 
                                     'button_class' => 'btn-danger', 
                                     'icon_class' => 'fa fa-times'
                                    ]
                       ]
                      ];

        return $this->render('Admin/' . $this->entityName . '/list.html.twig', 
                             ['table_conf' => $table_conf, 
                              'elements' => $entities, 
                              'parent' => $entityParent
                             ]
                            );
    }

    /**
     * @Route("catalogo-productos/{idCatalogue}/agregar", 
     *         defaults={"idCatalogue"=null}, 
     *         requirements={"idCatalogue"="\d+"}, 
     *         name="admin_catalogueproduct_add"
     * )
     * @Route("catalogo-productos/{idCatalogue}/editar/{idCatalogueProduct}", 
     *         defaults={"idCatalogueProduct"=null}, 
     *         requirements={"idCatalogue"="\d+", "idCatalogueProduct"="\d+"}, 
     *         name="admin_catalogueproduct_edit"
     * )
     */
    public function edit(Request $request, $idCatalogue, $idCatalogueProduct = null){
        $parentParameterId = $this->parentParameterId;
        $entityParent = $this->entityParentFromId($$parentParameterId);
        $parameterId = $this->parameterId;
        $entity = $this->entityFromId($$parentParameterId, $$parameterId);
        $entityForm = $this->createForm(EntityFormType::class, $entity);

        $entityForm->handleRequest($request);
        if ($entityForm->isSubmitted() && $entityForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlash(
                'success',
                ucfirst($this->entityLabel) . ' <strong>' . $entity . '</strong> guardada!'
            );

            switch($entityForm->getClickedButton()->getName()){
                case 'save_edit':
                    return $this->redirectToRoute($this->routeEdit, [$this->parentParameterId => $entityParent->getId(), $this->parameterId => $entity->getId()]);
                    break;
                case 'save_new':
                    return $this->redirectToRoute($this->routeAdd, [$this->parentParameterId => $entityParent->getId()]);
                    break;
                case 'save_list':
                    return $this->redirectToRoute($this->routeList, [$this->parentParameterId => $entityParent->getId()]);
                    break;
                default: 
                    return $this->redirectToRoute($this->routeEdit, [$this->parentParameterId => $entityParent->getId(), $this->parameterId => $entity->getId()]);
            }
        }

        return $this->render('Admin/' . $this->entityName . '/edit.html.twig', [
            'form' => $entityForm->createView(),
            'cancel_url' => $this->generateUrl($this->routeList, [$this->parentParameterId => $entityParent->getId()]), 
            'parent' => $entityParent
        ]);
    }

    /**
     * @Route("catalogo-productos/{idCatalogue}/eliminar/{idCatalogueProduct}", 
     *         requirements={"idCatalogue"="\d+", "idCatalogueProduct"="\d+"}, 
     *         name="admin_catalogueproduct_delete"
     * )
     */
    public function delete(Request $request, $idCatalogue, $idCatalogueProduct){
        $parentParameterId = $this->parentParameterId;
        $entityParent = $this->entityParentFromId($$parentParameterId);
        $parameterId = $this->parameterId;
        $entity = $this->entityFromId($$parentParameterId, $$parameterId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);

        $em->flush();

        $this->addFlash(
            'success',
            ucfirst($this->entityLabel) . ' <strong>' . $entity . '</strong> eliminada!'
        );

        return $this->redirect($this->generateUrl($this->routeList, [$this->parentParameterId => $entityParent->getId()]));
    }

    public function entityFromId($idEntityParent, $idEntity = null){
        $entityParent = $this->entityParentFromId($idEntityParent);

        if($idEntity != null){
            $entity = $this->getDoctrine()
                           ->getRepository(EntityCrud::class)
                           ->findOneBy([$this->parentField => $entityParent, 'id' => $idEntity]);
            if(!$entity){
                throw $this->createNotFoundException(ucfirst($this->entityLabel) . ' no existe');
            }
        }else{
            $setParentMethod = 'set' . $this->parentClass;
            $entity = new EntityCrud;
            $entity->$setParentMethod($entityParent);
        }

        return $entity;
    }

    public function entityParentFromId($idEntityParent){
        $entityParent = $this->getDoctrine()
                       ->getRepository(EntityParentCrud::class)
                       ->find($idEntityParent);
        if(!$entityParent){
            throw $this->createNotFoundException(ucfirst($this->parentLabel) . ' no existe');
        }

        return $entityParent;
    }
}