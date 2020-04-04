<?php
namespace App\Controller\FOSUserBundle;

use \FOS\UserBundle\Controller\RegistrationController as BaseController;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Form\Factory\FormFactory;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegistrationController extends BaseController
{
    protected $container;

    public function __construct(ContainerInterface $container, EventDispatcherInterface $eventDispatcher){
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $this->container->get('fos_user.registration.form.factory');
        $this->userManager = $this->container->get('fos_user.user_manager.default');
        $this->tokenStorage = $this->container->get('security.token_storage');
    }
}