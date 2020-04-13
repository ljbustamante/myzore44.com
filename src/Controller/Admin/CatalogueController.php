<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Catalogue as EntityCrud;
use App\Form\Type\Admin\CatalogueType as EntityFormType;

class CatalogueController extends AbstractController
{
    protected $entityName = 'Catalogue';
    protected $entityLabel = 'Catalogo';
    protected $routeList = 'admin_catalogue_list';
    protected $routeAdd = 'admin_catalogue_add';
    protected $routeEdit = 'admin_catalogue_edit';
    protected $routeDelete = 'admin_catalogue_delete';
    protected $parameterId = 'idCatalogue';

    /**
     * @Route("catalogo/", name="admin_catalogue_list")
     */
    public function list(Request $request){
        $entities =  $this->getDoctrine()->getRepository(EntityCrud::class)->findAll();

        $table_conf = ['columns' => [
                        ['header_label' => 'Nombre de Catalogo', 'header_alignment' => 'left', 'field' => 'name', 'data_alignment' => 'left'], 
                        ['header_label' => 'Campaña', 'header_alignment' => 'left', 'field' => ['campaign', 'name'], 'data_alignment' => 'left'], 
                        ['header_label' => 'Inicio', 'header_alignment' => 'center', 'field' => 'startDate', 'data_alignment' => 'center'], 
                        ['header_label' => 'Final', 'header_alignment' => 'center', 'field' => 'endDate', 'data_alignment' => 'center'], 
                        ['header_label' => 'Activo', 'header_alignment' => 'center', 'field' => 'active', 'data_alignment' => 'center']
                       ], 
                       'cardinal' => true,
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
                                    ],
                        'products' => ['label' => 'Productos de ' . $this->entityLabel, 
                                    'route' => 'admin_catalogueproduct_list', 
                                    'name_id' => $this->parameterId, 
                                    'button_class' => 'btn-info', 
                                    'icon_class' => 'fa fa-cogs'
                                   ] 
                       ]
                      ];

        return $this->render('Admin/' . $this->entityName . '/list.html.twig', ['table_conf' => $table_conf, 'elements' => $entities]);
    }

    /**
     * @Route("catalogo/agregar", 
     *         name="admin_catalogue_add"
     * )
     * @Route("catalogo/editar/{idCatalogue}", 
     *         defaults={"idCatalogue"=null}, 
     *         requirements={"idCatalogue"="\d+"}, 
     *         name="admin_catalogue_edit"
     * )
     */
    public function edit(Request $request, $idCatalogue = null){
        $entity = $this->entityFromId($idCatalogue);
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
                    return $this->redirectToRoute($this->routeEdit, [$this->parameterId => $entity->getId()]);
                    break;
                case 'save_new':
                    return $this->redirectToRoute($this->routeAdd);
                    break;
                case 'save_list':
                    return $this->redirectToRoute($this->routeList);
                    break;
                default: 
                    return $this->redirectToRoute($this->routeEdit, [$this->parameterId => $entity->getId()]);
            }
        }

        return $this->render('Admin/' . $this->entityName . '/edit.html.twig', [
            'form' => $entityForm->createView(),
            'cancel_url' => $this->generateUrl($this->routeList)
        ]);
    }

    /**
     * @Route("catalogo/eliminar/{idCatalogue}", 
     *         requirements={"idCatalogue"="\d+"}, 
     *         name="admin_catalogue_delete"
     * )
     */
    public function delete(Request $request, $idCatalogue){
        $entity = $this->entityFromId($idCatalogue);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);

        $em->flush();

        $this->addFlash(
            'success',
            ucfirst($this->entityLabel) . ' <strong>' . $entity . '</strong> eliminada!'
        );

        return $this->redirect($this->generateUrl($this->routeList));
    }

    public function entityFromId($idEntity){
        if($idEntity != null){
            $entity = $this->getDoctrine()
                           ->getRepository(EntityCrud::class)
                           ->find($idEntity);
            if(!$entity){
                throw $this->createNotFoundException(ucfirst($this->entityLabel) . 'no existe');
            }
        }else{
            $entity = new EntityCrud();
        }

        return $entity;
    }
}