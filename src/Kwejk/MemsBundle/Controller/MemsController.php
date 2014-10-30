<?php

namespace Kwejk\MemsBundle\Controller;


use Kwejk\MemsBundle\Form\CommentType;
use Kwejk\MemsBundle\Form\AddCommentType;
use Kwejk\MemsBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Kwejk\CoreBundle\Controller\Controller;

class MemsController extends Controller {

    public function listAction() {
        $mems = $this->getDoctrine()
                ->getRepository('KwejkMemsBundle:Mem')
//                wyświetlanie po kategrii is Accepted
                ->findBy([
            'isAccepted' => true,
        ]);


        return $this->render('KwejkMemsBundle:Mems:list.html.twig', array(
                    'mems' => $mems,
        ));
    }

//   public function addAction() {
//       
//        
//        return $this->render('KwejkMemsBundle:Mems:add.html.twig', array(
//                'form' => $form,
//            ));   
//   }      


    public function showAction($slug) {
        $request = $this->getRequest();
        $ip = $request->getClientIp();
        
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

        $user = $this->getUser();
        
        if (!$user || !$user->hasRole('ROLE_USER')) {
            throw $this->createAccessDeniedException("Nie posiadasz odpowiednich uprawnień!");
        }
            $comment->setCreatedBy($user);
            $comment->setMem($mem);
            $comment->setIp($ip);
            $comment->setUserAgent($request->headers->get('User-Agent'));
            $comment->setHost($request->getHost());
            //TODO do przetestowania host i inne

            $form->handleRequest($request);
            if ($form->isValid()) {
//                $comment->setCreatedAt(getdate($timestamp));
                // save data
                $this->persist($comment);
                $this->addFlash('notice', "Komentarz został pomyślnie zapisany.");
 
                
                return $this->redirect($this->generateUrl('kwejk_mems_show', array(
                    'slug' => $mem->getSlug())
                        ));
            }
        return $this->render('KwejkMemsBundle:Mems:show.html.twig', array(
                    'mem' => $mem,
                    // [obiekt] nowy formularz przenosimy do funcji tworzenia widoku
                    //nasza pozycja w polu form będzie obiektem widoku
                    'form' => $form->createView(),
        ));
            
            }


        
    }


