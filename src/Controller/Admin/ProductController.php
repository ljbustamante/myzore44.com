<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product as EntityCrud;
use App\Form\Type\Admin\ProductType as EntityFormType;
use App\Form\Type\Admin\Product\ProductGroupAttributesValueType;

class ProductController extends AbstractController
{
    protected $entityName = 'Product';
    protected $entityLabel = 'Producto';
    protected $routeList = 'admin_product_list';
    protected $routeAdd = 'admin_product_add';
    protected $routeEdit = 'admin_product_edit';
    protected $routeDelete = 'admin_product_delete';
    protected $parameterId = 'idProduct';

    /**
     * @Route("producto/", name="admin_product_list")
     */
    public function list(Request $request){
        $entities =  $this->getDoctrine()->getRepository(EntityCrud::class)->findAll();

        $table_conf = ['columns' => [
                        ['header_label' => 'Código', 'header_alignment' => 'left', 'field' => 'code', 'data_alignment' => 'left'], 
                        ['header_label' => 'Nombre', 'header_alignment' => 'left', 'field' => 'name', 'data_alignment' => 'left'], 
                        ['header_label' => 'Tipo', 'header_alignment' => 'left', 'field' => 'productType', 'data_alignment' => 'left'], 
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
                        'attributeValue' => ['label' => 'Valor de atributos de ' . $this->entityLabel, 
                                    'route' => 'admin_product_groupsattributevalue', 
                                    'name_id' => $this->parameterId, 
                                    'button_class' => 'btn-info', 
                                    'icon_class' => 'fa fa-cogs'
                                   ]
                       ]
                      ];

        return $this->render('Admin/' . $this->entityName . '/list.html.twig', ['table_conf' => $table_conf, 'elements' => $entities]);
    }

    /**
     * @Route("producto/agregar", 
     *         name="admin_product_add"
     * )
     * @Route("producto/editar/{idProduct}", 
     *         defaults={"idProduct"=null}, 
     *         requirements={"idProduct"="\d+"}, 
     *         name="admin_product_edit"
     * )
     */
    public function edit(Request $request, $idProduct = null){
        $entity = $this->entityFromId($idProduct);
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
     * @Route("producto/eliminar/{idProduct}", 
     *         requirements={"idProduct"="\d+"}, 
     *         name="admin_product_delete"
     * )
     */
    public function delete(Request $request, $idProduct){
        $entity = $this->entityFromId($idProduct);

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

    /**
     * @Route("producto/valor-atributos/{idProduct}", 
     *         defaults={"idProduct"=null}, 
     *         requirements={"idProduct"="\d+"}, 
     *         name="admin_product_groupsattributevalue"
     * )
     */
    public function groupsAttributeValue(Request $request, $idProduct = null){
        $entity = $this->entityFromId($idProduct);
        $entityForm = $this->createForm(ProductGroupAttributesValueType::class, $entity);

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

        return $this->render('Admin/' . $this->entityName . '/groupsAttributeValue.html.twig', [
            'form' => $entityForm->createView(),
            'cancel_url' => $this->generateUrl($this->routeList)
        ]);
    }
}