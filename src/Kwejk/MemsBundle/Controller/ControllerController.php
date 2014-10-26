<?php

namespace Kwejk\MemsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ControllerController extends Controller
{
    public function newAction()
    {
        return $this->render('KwejkMemsBundle:Controller:new.html.twig', array(
                // ...
            ));    }

    public function editAction($id)
    {
        return $this->render('KwejkMemsBundle:Controller:edit.html.twig', array(
                // ...
            ));    }

}
