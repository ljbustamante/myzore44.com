<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Provider as EntityCrud;
use App\Form\Type\Admin\ProviderType as EntityFormType;

class ProviderController extends AbstractController
{
    protected $entityName = 'Provider';
    protected $entityLabel = 'Proveedor';
    protected $routeList = 'admin_provider_list';
    protected $routeAdd = 'admin_provider_add';
    protected $routeEdit = 'admin_provider_edit';
    protected $routeDelete = 'admin_provider_delete';
    protected $parameterId = 'idProvider';

    /**
     * @Route("proveedor/", name="admin_provider_list")
     */
    public function list(Request $request){
        $entities =  $this->getDoctrine()->getRepository(EntityCrud::class)->findAll();

        $table_conf = ['columns' => [
                        ['header_label' => 'Proveedor', 'header_alignment' => 'left', 'field' => 'provider', 'data_alignment' => 'left'], 
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
     * @Route("proveedor/agregar", 
     *         name="admin_provider_add"
     * )
     * @Route("proveedor/editar/{idProvider}", 
     *         defaults={"idProvider"=null}, 
     *         requirements={"idProvider"="\d+"}, 
     *         name="admin_provider_edit"
     * )
     */
    public function edit(Request $request, $idProvider = null){
        $entity = $this->entityFromId($idProvider);
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
     * @Route("proveedor/eliminar/{idProvider}", 
     *         requirements={"idProvider"="\d+"}, 
     *         name="admin_provider_delete"
     * )
     */
    public function delete(Request $request, $idProvider){
        $entity = $this->entityFromId($idProvider);

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