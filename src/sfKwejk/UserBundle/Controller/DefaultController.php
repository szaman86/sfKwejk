<?php

namespace sfKwejk\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('sfKwejkUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
