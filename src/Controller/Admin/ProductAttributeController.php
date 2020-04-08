<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProductAttribute as EntityCrud;
use App\Form\Type\Admin\ProductAttributeType as EntityFormType;

class ProductAttributeController extends AbstractController
{
    protected $entityName = 'ProductAttribute';
    protected $entityLabel = 'Atributo de Producto';
    protected $routeList = 'admin_productattribute_list';
    protected $routeAdd = 'admin_productattribute_add';
    protected $routeEdit = 'admin_productattribute_edit';
    protected $routeDelete = 'admin_productattribute_delete';
    protected $parameterId = 'idProductAttribute';

    /**
     * @Route("productoatributo/", name="admin_productattribute_list")
     */
    public function list(Request $request){
        $entities =  $this->getDoctrine()->getRepository(EntityCrud::class)->findAll();

        $table_conf = ['columns' => [
                        ['header_label' => 'Atrinuto de Producto', 'header_alignment' => 'left', 'field' => 'productAttribute', 'data_alignment' => 'left'], 
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
                                    ]
                       ]
                      ];

        return $this->render('Admin/' . $this->entityName . '/list.html.twig', ['table_conf' => $table_conf, 'elements' => $entities]);
    }

    /**
     * @Route("productoatributo/agregar", 
     *         name="admin_productattribute_add"
     * )
     * @Route("productoatributo/editar/{idProductAttribute}", 
     *         defaults={"idProductAttribute"=null}, 
     *         requirements={"idProductAttribute"="\d+"}, 
     *         name="admin_productattribute_edit"
     * )
     */
    public function edit(Request $request, $idProductAttribute = null){
        $entity = $this->entityFromId($idProductAttribute);
        $entityForm = $this->createForm(EntityFormType::class, $entity);

        $entityForm->handleRequest($request);
        if ($entityForm->isSubmitted() && $entityForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

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
     * @Route("productoatributo/eliminar/{idProductAttribute}", 
     *         requirements={"idProductAttribute"="\d+"}, 
     *         name="admin_productattribute_delete"
     * )
     */
    public function delete(Request $request, $idProductAttribute){
        $entity = $this->entityFromId($idProductAttribute);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);

        $em->flush();

        $this->addFlash(
            'success',
            ucfirst($this->entityLabel) . ' <strong>' . $entity . '</strong> eliminado!'
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