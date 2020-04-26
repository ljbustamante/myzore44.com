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
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
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
    private $map;
    private $iconChilds = 'fa-minus';

    /**
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(AuthorizationCheckerInterface $security, FirewallMap $map)
    {
        $this->security = $security;
        $this->map = $map;
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
        $firewall = $this->map->getFirewallConfig($request)->getName();

        $menuItems = [];
        if($firewall == 'admin'){
            $menuItems = $this->getMenuAdmin($request);
        }elseif($firewall == 'promoter'){
            $menuItems = $this->getMenuPromoter($request);
        }

        foreach ($menuItems as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenuAdmin(Request $request) {
		// Build your menu here by constructing a MenuItemModel array
		$menuItems = array(
            $panel = new MenuItemModel('panel', 'Panel', 'admin_home_index', [], 'iconclasses fa fa-tachometer-alt'),
            $usuario = new MenuItemModel('usuario', 'Usuarios', null, [], 'iconclasses fa fa-users'),
            $genero = new MenuItemModel('genre', 'Géneros', 'admin_genre_list', [], 'iconclasses fa fa-sitemap'),
            $proveedor = new MenuItemModel('provider', 'Proveedores', 'admin_provider_list', [], 'iconclasses fa fa-cubes'),
            $ordencompra = new MenuItemModel('shoporder', 'Órdenes de compra', 'admin_shoporder_list', [], 'iconclasses fa fa-cubes'),
            $almacen = new MenuItemModel('depot', 'Almacenes', 'admin_provider_list', [], 'iconclasses fa fa-cube'),
            $campana = new MenuItemModel('campana', 'Campañas', null, [], 'iconclasses fa fa-plane'),
            $producto = new MenuItemModel('producto', 'Productos', null, [], 'iconclasses fa fa-briefcase'),
            $salir = new MenuItemModel('salir', 'Salir', 'admin_fos_user_security_logout', [], 'iconclasses fa fa-sign-out-alt'),
        );

        $usuario->addChild(new MenuItemModel('admins', 'Administradores', 'admin_admin_list', [], 'iconclasses fa ' . $this->iconChilds));
        $usuario->addChild(new MenuItemModel('promoters', 'Promotores', 'admin_promoter_list', [], 'iconclasses fa ' . $this->iconChilds));
        $usuario->addChild(new MenuItemModel('clients', 'Clientes', 'admin_client_list', [], 'iconclasses fa ' . $this->iconChilds));
        
        $campana->addChild(new MenuItemModel('campana', 'Campañas', 'admin_campaign_list', [], 'iconclasses fa ' . $this->iconChilds));
        $campana->addChild(new MenuItemModel('catalogue', 'Catálogos', 'admin_catalogue_list', [], 'iconclasses fa ' . $this->iconChilds));

        $producto->addChild(new MenuItemModel('product', 'Productos', 'admin_product_list', [], 'iconclasses fa ' . $this->iconChilds));
        $producto->addChild(new MenuItemModel('producttype', 'Tipos de Producto', 'admin_producttype_list', [], 'iconclasses fa ' . $this->iconChilds));
        $producto->addChild(new MenuItemModel('productattribute', 'Atributos de producto', 'admin_productattribute_list', [], 'iconclasses fa ' . $this->iconChilds));

        $this->activateByRoute($request->get('_route'), $menuItems);
        return $menuItems;
	}

    protected function getMenuPromoter(Request $request) {
        // Build your menu here by constructing a MenuItemModel array
        $menuItems = array(
            $panel = new MenuItemModel('panel', 'Panel', 'promoter_home_index', [], 'iconclasses fa fa-tachometer-alt'),
            $pedido = new MenuItemModel('pedido', 'Pedidos', null, [], 'iconclasses fa fa-user'),
            $usuario = new MenuItemModel('usuario', 'Clientes', null, [], 'iconclasses fa fa-users'),
            $salir = new MenuItemModel('salir', 'Salir', 'promoter_fos_user_security_logout', [], 'iconclasses fa fa-sign-out-alt'),
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
