<?php

namespace Kwejk\LayoutBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Strona główna', [
            'route' => 'kwejk_mems_list'
        ]);
        $menu->addChild('Poczekalnia', [
            'route' => 'kwejk_mems_poczekalnia'
//            'uri' => '#'
        ]);
        $menu->addChild('Top', [
//            'route' => 'sf_kwejk_list_top'
            'uri' => '#'
        ]);
        $menu->addChild('Losuj', [
            'route' => 'kwejk_random'
//            'uri' => '#'
        ]);
        $menu->addChild('Konto', [
            'uri' => '#'
        ]);

        return $menu;
    }

    public function userMenuAuthenticated(FactoryInterface $factory, array $options) {
        // tworzymy korzeń
        $menu = $factory->createItem(('root'));
        // rozumiem że tu wrzucamy klasę div'a czy jakas tam inna 
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        // i pokolei wymieniamy składniki głównego menu
        // Najpierw zajmujemy się Przyciskiem User
        // Robimy z niego dropdown więc przypisujemy mu specjalne atrybujty.
        // Najpierw jemu samemu a potem jego dzieciakom
        $menu->addChild('User', ['uri' => '#'])
                ->setAttribute('class', 'dropdown')
                ->setLinkAttribute('class', 'dropdown-toggle')
                ->setLinkAttribute('data-toggle', 'dropdown')
                ->setChildrenAttribute('class', 'dropdown-menu');
        //Dobieramy się do tablicy Przycisku [USER] 
        $menu['User']->addChild('Profil', array('route' => 'fos_user_profile_edit'))
                ->setAttribute('divider_append', true);
        $menu['User']->addChild('WYloguj', array('route' => 'fos_user_security_logout'));
        $menu['User']->addChild('Dodaj Mema', ['route'=> 'kwejk_mems_add']);

        return $menu;
    }

    public function userMenuNotAuthenticated(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem(('root'));
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        
        $menu->addChild('Zaloguj', [
            'route' => 'fos_user_security_login'
        ]);
        
        return $menu;
    }
    
    

// Koniec klasy
}
