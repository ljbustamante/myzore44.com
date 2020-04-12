<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber\AdminLTE;

use KevinPapst\AdminLTEBundle\Event\BreadcrumbMenuEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuBuilder configures the main navigation.
 */
class MenuBuilderSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    /**
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SidebarMenuEvent::class => ['onSetupNavbar', 100],
            BreadcrumbMenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    /**
     * Generate the main menu.
     *
     * @param SidebarMenuEvent $event
     */
    public function onSetupNavbar(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        if($this->security->isGranted('ROLE_ADMIN')){
            $menuItems = $this->getMenuAdmin($request);
        }elseif($this->security->isGranted('ROLE_PROMOTER')){
            $menuItems = $this->getMenuPromoter($request);
        }

        foreach ($menuItems as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenuAdmin(Request $request) {
		// Build your menu here by constructing a MenuItemModel array
		$menuItems = array(
            $panel = new MenuItemModel('panel', 'Panel', 'admin_home_index', array(/* options */), 'iconclasses fa fa-tachometer-alt'),
            $genero = new MenuItemModel('genre', 'Géneros', 'admin_genre_list', array(), 'iconclasses fa fa-sitemap'),
            $campana = new MenuItemModel('campana', 'Campañas', null, array(/* options */), 'iconclasses fa fa-plane'),
            $producto = new MenuItemModel('producto', 'Productos', null, array(/* options */), 'iconclasses fa fa-briefcase'),
        );

        $campana->addChild(new MenuItemModel('camapana', 'Camapañas', 'admin_campaign_list', array(/* options */), 'iconclasses fa fa-cogs'));
        $campana->addChild(new MenuItemModel('catalogue', 'Catálogos', 'admin_catalogue_list', array(/* options */), 'iconclasses fa fa-dollar'));

        $producto->addChild(new MenuItemModel('product', 'Productos', 'admin_product_list', array(/* options */), 'iconclasses fa fa-dollar'));
        $producto->addChild(new MenuItemModel('producttype', 'Tipos de Producto', 'admin_producttype_list', array(/* options */), 'iconclasses fa fa-dollar'));
        $producto->addChild(new MenuItemModel('productattribute', 'Atributos de producto', 'admin_productattribute_list', array(/* options */), 'iconclasses fa fa-dollar'));

        $this->activateByRoute($request->get('_route'), $menuItems);
        return $menuItems;
	}

    protected function getMenuPromoter(Request $request) {
        // Build your menu here by constructing a MenuItemModel array
        $menuItems = array(
            $panel = new MenuItemModel('panel', 'Panel', 'promoter_home_index', array(/* options */), 'iconclasses fa fa-tachometer-alt'),
        );
        
        $this->activateByRoute($request->get('_route'), $menuItems);
        return $menuItems;
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}
