<?php

// src/AppBundle/Menu/Builder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareInterface;
// use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * MenuBuilder en tant que service (cf. http://symfony.com/doc/master/bundles/KnpMenuBundle/menu_builder_service.html)
 *
 */
class MenuBuilder
{
    private $factory;
    private $container;
    
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, Container $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }
    
    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar navbar-inverse');
        
        $menu->addChild('Accueil', array('route' => 'front_home'))
        ->setAttributes(array(
            'class' => 'nav-link',
            'icon' => 'fa fa-list'
        ));
        
        
        
        $isConnected=false;
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $isConnected=true;
        }
        
        if($isConnected) {
            $menu->addChild('Mon Panier', array('route' => 'panier'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        }
        
        if($isConnected && $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            // Children for connected users
            $menu->addChild('Edit circuits', array('route' => 'admin_circuit_index'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
            $menu->addChild('Edit étapes', array('route' => 'admin_etape_index'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
            
            $menu->addChild('Les reservations', array('route' => 'res_index'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        
        }
        
        return $menu;
    }
    
    public function createUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav ml-auto');
        
        //if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        $isConnected=false;
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $isConnected=true;
        }
        
      
   
        if($isConnected) {
            $menu->addChild('Déconnexion', array('route' => 'fos_user_security_logout'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        }
        else{
            $menu->addChild('Connexion', array('route' => 'fos_user_security_login'))
            ->setAttributes(array(
                'class' => 'nav-link',
                'icon' => 'fa fa-list'
            ));
        }
        
        
        return $menu;
    }
    
}
