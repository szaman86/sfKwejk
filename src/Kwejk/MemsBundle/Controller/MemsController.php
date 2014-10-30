<?php

namespace Kwejk\MemsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kwejk\MemsBundle\Form\CommentType;
use Kwejk\MemsBundle\Form\AddCommentType;
use Kwejk\MemsBundle\Entity\Comment;

class MemsController extends Controller {
    public function listAction() {
        $mems = $this->getDoctrine()
                ->getRepository('KwejkMemsBundle:Mem')
//                wyświetlanie po kategrii is Accepted
                ->findBy([
                    'isAccepted' => true,
                ]);
                
        
        return $this->render('KwejkMemsBundle:Mems:list.html.twig', array(
                'mems' =>$mems,
            ));    }

//   public function addAction() {
//       
//        
//        return $this->render('KwejkMemsBundle:Mems:add.html.twig', array(
//                'form' => $form,
//            ));   
//   }      


   public function showAction($slug) {
        $mem = $this->getDoctrine()
                ->getRepository('KwejkMemsBundle:Mem')
//                Potrzebujemy tylko jeden rekord
                ->findOneBy([
                    'slug' => $slug,
                ]);
        if (!$mem) {
            throw $this->createNotFoundException('Mem nie istnieje');
        }
        
        // Z encji Comment tworzymy nowy rekord
        //Dodajemy formularz
        $comment = new Comment();
        $form = $this->createForm(new AddCommentType(), $comment);
        
        
        return $this->render('KwejkMemsBundle:Mems:show.html.twig', array(
                'mem' => $mem,
            // [obiekt] nowy formularz przenosimy do funcji tworzenia widoku
            //nasza pozycja w polu form będzie obiektem widoku
                'form' => $form->createView(),
            ));    }
}