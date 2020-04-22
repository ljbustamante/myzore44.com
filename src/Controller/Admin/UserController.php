<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use BeSimple\I18nRoutingBundle\Routing\Annotation\I18nRoute;
use A2lix\I18nDoctrineBundle\Annotation\I18nDoctrine;
use App\Form\Type\Admin\UserType as EntityFormType;
use App\Form\Type\Admin\UserPasswordType;
use App\Entity\User as EntityCrud;

use FOS\UserBundle\Model\UserManagerInterface;

class UserController extends AbstractController
{
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_PROMOTER = "ROLE_PROMOTER";

    const ROUTE_ADMIN_LIST = 'admin_admin_list';
    const ROUTE_ADMIN_EDIT = 'admin_admin_edit';
    const ROUTE_ADMIN_DELETE = 'admin_admin_delete';

    const ROUTE_PROMOTER_LIST = 'admin_promoter_list';
    const ROUTE_PROMOTER_EDIT = 'admin_promoter_edit';
    const ROUTE_PROMOTER_DELETE = 'admin_promoter_delete';

    const ROUTE_CLIENT_LIST = 'admin_client_list';
    const ROUTE_CLIENT_EDIT = 'admin_client_edit';
    const ROUTE_CLIENT_DELETE = 'admin_client_delete';

    const ENTITY_ADMIN_LABEL = 'administrador';
    const ENTITY_PROMOTER_LABEL = 'promotor';
    const ENTITY_CLIENT_LABEL = 'cliente';

    const ENTITY_ADMIN_TITLE = 'Administradores';
    const ENTITY_PROMOTER_TITLE = 'Pomotores';
    const ENTITY_CLIENT_TITLE = 'Clientes';

    const ENTITY_CLASS = 'User';
    const ENTITY_PARAMETER_ID = 'idUser';

    private $userManager;

    public function __construct(UserManagerInterface $userManager){
        $this->userManager = $userManager;
    }

    /**
     * @Route("administrador/listar", name="admin_admin_list")
     * @Route("promotor/listar", name="admin_promoter_list")
     * @Route("cliente/listar", name="admin_client_list")
     */
    public function listAction(Request $request)
    {
        $routeVars = $this->defineRouteConfs($request->get('_route'));

        $entityRepository = $this->getDoctrine()
                          ->getRepository(EntityCrud::class);
        $qb = $entityRepository->createQueryBuilder('e');
        $qb->andWhere("e.roles = :roles")->setParameter("roles", serialize($routeVars['role']));
        $entities = $qb->getQuery()->getResult();

        $table_conf = ['columns' => [
                        ['header_label' => 'Usuario', 'header_alignment' => 'left', 'field' => 'username', 'data_alignment' => 'left'], 
                        ['header_label' => 'Activo', 'header_alignment' => 'center', 'field' => 'enabled', 'data_alignment' => 'center'], 
                        ['header_label' => 'Último ingreso', 'header_alignment' => 'center', 'field' => 'lastLogin', 'data_alignment' => 'center'], 
                       ], 
                       'cardinal' => true,
                       'new_button' => ['label' => 'Agregar ' . $routeVars['entityLabel'], 'route' => $routeVars['routeAdd']],
                       'actions' => [
                        'edit' => ['label' => 'Editar ' . $routeVars['entityLabel'], 
                                   'route' => $routeVars['routeEdit'], 
                                   'name_id' => self::ENTITY_PARAMETER_ID, 
                                   'button_class' => 'btn-success', 
                                   'icon_class' => 'fa fa-edit'
                                  ],
                        'delete' => ['label' => 'Eliminar ' . $routeVars['entityLabel'], 
                                     'route' => $routeVars['routeDelete'], 
                                     'name_id' => self::ENTITY_PARAMETER_ID, 
                                     'button_class' => 'btn-danger', 
                                     'icon_class' => 'fa fa-times'
                                    ],
                        'password' => ['label' => 'Actualizar clave', 
                                       'route' => $routeVars['routeUpdPass'], 
                                       'name_id' => self::ENTITY_PARAMETER_ID, 
                                       'button_class' => 'btn-info', 
                                       'icon_class' => 'fa fa-cogs'
                                      ] 
                       ],
                       'title' => $routeVars['entityTitle'] 
                      ];

        return $this->render('Admin/' . self::ENTITY_CLASS . '/list.html.twig', ['table_conf' => $table_conf, 'elements' => $entities]);
    }

    /**
     * @Route("administrador/agregar", name="admin_admin_add")
     * @Route("promotor/agregar", name="admin_promoter_add")
     * @Route("cliente/agregar", name="admin_client_add")
     * @Route("administrador/editar/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_admin_edit")
     * @Route("promotor/editar/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_promoter_edit")
     * @Route("cliente/editar/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_client_edit")
     */
    public function editAction(Request $request, $idUser = null)
    {
        //$userManager = $this->get('fos_user.user_manager.default');

        $parameterId = self::ENTITY_PARAMETER_ID;

        $routeVars = $this->defineRouteConfs($request->get('_route'));

        dump($routeVars);
        $entity = $this->entityFromId($$parameterId, $routeVars['role']);

        $entityForm = $this->createForm(EntityFormType::class, $entity, []);

        $entityForm->handleRequest($request);
 
        if ($entityForm->isSubmitted() && $entityForm->isValid()) {
            $this->userManager->updateUser($entity, true);

            $this->addFlash(
                'success',
                ucfirst($routeVars['entityLabel']) . ' <strong>' . $entity . '</strong> guardado!'
            );

            switch($entityForm->getClickedButton()->getName()){
                case 'save_edit':
                    return $this->redirectToRoute($routeVars['routeEdit'], [self::ENTITY_PARAMETER_ID => $entity->getId()]);
                    break;
                case 'save_new':
                    return $this->redirectToRoute($routeVars['routeEdit']);
                    break;
                case 'save_list':
                    return $this->redirectToRoute($routeVars['routeList']);
                    break;
                default: 
                    return $this->redirectToRoute($routeVars['routeEdit'], [self::ENTITY_PARAMETER_ID => $entity->getId()]);
            }
        }
        // replace this example code with whatever you need
        return $this->render('Admin/' . self::ENTITY_CLASS . '/edit.html.twig', ['form' => $entityForm->createView(), 'cancel_url' => $this->generateUrl($routeVars['routeList'])]);
    }

    /**
     * @Route("administrador/eliminar/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_admin_delete")
     * @Route("promotor/eliminar/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_promoter_delete")
     * @Route("cliente/eliminar/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_client_delete")
     */
    public function deleteAction(Request $request, $idUser = null)
    {
        $parameterId = self::ENTITY_PARAMETER_ID;
        $routeVars = $this->defineRouteConfs($request->get('_route'));
        $entity = $this->entityFromId($$parameterId, $routeVars['role']);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);

        $em->flush();

        $this->addFlash(
            'success',
            ucfirst($routeVars['entityLabel']) . ' <strong>' . $entity . '</strong> eliminado!'
        );

        return $this->redirect($this->generateUrl($routeVars['routeList']));
    }

    /**
     * @Route("administrador/actualizar-clave/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_admin_updatepass")
     * @Route("promotor/actualizar-clave/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_promoter_updatepass")
     * @Route("cliente/actualizar-clave/{idUser}", defaults={"idUser"=null}, requirements={"idUser"="\d+"}, name="admin_client_updatepass")
     */
    public function updatePassword(Request $request, $idUser = null){
        $routeVars = $this->defineRouteConfs($request->get('_route'));
        $entity = $this->entityFromId($idUser, $routeVars['role']);
        $entityForm = $this->createForm(UserPasswordType::class, $entity);

        $entityForm->handleRequest($request);
        if ($entityForm->isSubmitted() && $entityForm->isValid()) {
            $this->userManager->updateUser($entity, true);
            $this->addFlash(
                'success',
                ucfirst($routeVars['entityLabel']) . ' <strong>' . $entity . '</strong> guardado!'
            );

            return $this->redirectToRoute($routeVars['routeList']);
        }

        return $this->render('Admin/' . self::ENTITY_CLASS . '/updatePassword.html.twig', [
            'form' => $entityForm->createView(),
            'cancel_url' => $this->generateUrl($routeVars['routeList'])
        ]);
    }

    public function entityFromId($idEntity, $role){
        //$userManager = $this->container->get('fos_user.user_manager');

        if($idEntity != null){
            $entityRepository = $this->getDoctrine()
                                ->getRepository(EntityCrud::class);
            $qb = $entityRepository->createQueryBuilder('e');
            $qb->andWhere("e.id = :id")->setParameter("id", $idEntity);
            $qb->andWhere("e.roles = :roles")->setParameter("roles", serialize($role));
            $entity = $qb->getQuery()->getOneOrNullResult();

            if(!$entity){
                throw $this->createNotFoundException('Usuario no existe');
            }
        }else{
            $entity = new EntityCrud();
            $entity->setRoles($role);
        }

        return $entity;
    }

    private function defineRouteConfs($routeName){
        switch($routeName){
            case 'admin_admin_list':
            case 'admin_admin_add':
            case 'admin_admin_edit':
            case 'admin_admin_delete':
            case 'admin_admin_updatepass':
                $routeVars['role'] = [self::ROLE_ADMIN];
                $routeVars['entityLabel'] = self::ENTITY_ADMIN_LABEL;
                $routeVars['entityTitle'] = self::ENTITY_ADMIN_TITLE;
                $routeVars['routeList'] = self::ROUTE_ADMIN_LIST;
                $routeVars['routeAdd'] = 'admin_admin_add';
                $routeVars['routeEdit'] = self::ROUTE_ADMIN_EDIT;
                $routeVars['routeUpdPass'] = 'admin_admin_updatepass';
                $routeVars['routeDelete'] = self::ROUTE_ADMIN_DELETE;
                break;
            case 'admin_promoter_list':
            case 'admin_promoter_add':
            case 'admin_promoter_edit':
            case 'admin_promoter_delete':
            case 'admin_promoter_updatepass':
                $routeVars['role'] = [self::ROLE_PROMOTER];
                $routeVars['entityLabel'] = self::ENTITY_PROMOTER_LABEL;
                $routeVars['entityTitle'] = self::ENTITY_PROMOTER_TITLE;
                $routeVars['routeList'] = self::ROUTE_PROMOTER_LIST;
                $routeVars['routeAdd'] = 'admin_promoter_add';
                $routeVars['routeEdit'] = self::ROUTE_PROMOTER_EDIT;
                $routeVars['routeUpdPass'] = 'admin_promoter_updatepass';
                $routeVars['routeDelete'] = self::ROUTE_PROMOTER_DELETE;
                break;
            default:
                $routeVars['role'] = [];
                $routeVars['entityLabel'] = self::ENTITY_CLIENT_LABEL;
                $routeVars['entityTitle'] = self::ENTITY_CLIENT_TITLE;
                $routeVars['routeList'] = self::ROUTE_CLIENT_LIST;
                $routeVars['routeAdd'] = 'admin_client_add';
                $routeVars['routeEdit'] = self::ROUTE_CLIENT_EDIT;
                $routeVars['routeUpdPass'] = 'admin_client_updatepass';
                $routeVars['routeDelete'] = self::ROUTE_CLIENT_DELETE;
        }

        return $routeVars;
    }
}
