<?php

namespace Kwejk\LayoutBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-tabs');

        $menu->addChild('Strona główna', [
            'route' => 'kwejk_mems_list'
        ]);
        $menu->addChild('Poczekalnia', [
//            'route' => 'sf_kwejk_list_waiting'
            'uri' => '#'
        ]);
        $menu->addChild('Top', [
//            'route' => 'sf_kwejk_list_top'
            'uri' => '#'
        ]);
        $menu->addChild('Losuj', [
//            'route' => 'sf_kwejk_random'
            'uri' => '#'
        ]);
        $menu->addChild('Konto', [
            'uri' => '#'
        ]);
        
        return $menu;
    }
}