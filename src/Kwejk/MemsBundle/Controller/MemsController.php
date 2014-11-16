<?php

namespace Kwejk\MemsBundle\Controller;

use Kwejk\MemsBundle\Form\CommentType;
use Kwejk\MemsBundle\Form\AddCommentType;
use Kwejk\MemsBundle\Form\AddMemType;
use Kwejk\MemsBundle\Form\AddRatingType;
use Kwejk\MemsBundle\Entity\Comment;
use Kwejk\MemsBundle\Entity\Rating;
use Symfony\Component\HttpFoundation\Request;
use Kwejk\CoreBundle\Controller\Controller;
use Kwejk\MemsBundle\Entity\Mem;

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

    public function randomAction() {
        $mem = $this->getDoctrine()
                ->getRepository('KwejkMemsBundle:Mem')
                ->getRandom();
        return $this->render('KwejkMemsBundle:Mems:show.html.twig', array(
                    'mem' => $mem,
        ));
    }

    public function poczekalniaAction() {
        $mems = $this->getDoctrine()
                ->getRepository('KwejkMemsBundle:Mem')
//                wyświetlanie po kategrii is Accepted
                ->findBy([
            'isAccepted' => false,
        ]);

        if (!$mems) {
            throw $this->createNotFoundException('Brak Memow w poczekalni');
        }


        return $this->render('KwejkMemsBundle:Mems:list.html.twig', array(
                    'mems' => $mems,
        ));
    }

//    public function topAction() {
//
//        $mems = $this->getDoctrine()
//                ->getRepository('KwejkMemsBundle:Mem')
////                wyświetlanie po kategrii is Accepted
//                ->findBy([
//            'isAccepted' => false,
//        ]);
//    }

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
            throw $this->createNotFoundException('Mema nie istnieje');
        }

        // Z encji Comment tworzymy nowy rekord
        //Dodajemy formularz
        $rating = new Rating();
        $formRating = $this->createForm(new AddRatingType(), $rating);

        $comment = new Comment();
        $formComment = $this->createForm(new AddCommentType(), $comment);

        $user = $this->getUser();

        if (!$user || !$user->hasRole('ROLE_USER')) {
            throw $this->createAccessDeniedException("Nie posiadasz odpowiednich uprawnień!");
        }
        $comment->setCreatedBy($user);
//            $comment->setCreatedAt($request->headers->getDate('now'));
        $comment->setMem($mem);
        $comment->setIp($ip);
        $comment->setUserAgent($request->headers->get('User-Agent'));
        $comment->setHost($request->getHost());

        $rating->setCreatedBy($user);
        $rating->setCreatedAt(new \DateTime('now'));
        $rating->setMem($mem);


        $formComment->handleRequest($request);
        if ($formComment->isValid()) {
//                $comment->setCreatedAt(getdate($timestamp));
            // save data
            $this->persist($comment);
            $this->addFlash('notice', "Komentarz został pomyślnie zapisany.");


            return $this->redirect($this->generateUrl('kwejk_mems_show', array(
                                'slug' => $mem->getSlug())
            ));
        }
        $formRating->handleRequest($request);
        if ($formRating->isValid()) {
//                $comment->setCreatedAt(getdate($timestamp));
            // save data
            $this->persist($rating);
            $this->addFlash('notice', "Rating został pomyślnie zapisany.");


            return $this->redirect($this->generateUrl('kwejk_mems_show', array(
                                'slug' => $mem->getSlug())
            ));
        }


        return $this->render('KwejkMemsBundle:Mems:show.html.twig', array(
                    'mem' => $mem,
                    // [obiekt] nowy formularz przenosimy do funcji tworzenia widoku
                    //nasza pozycja w polu form będzie obiektem widoku
                    'formComment' => $formComment->createView(),
                    'formRating' => $formRating->createView(),
        ));
    }

    public function addAction(Request $request) {
        // Sprawdzamy czy mamy użytkownika
        $user = $this->getUser();

        if (!$user || !$user->hasRole('ROLE_USER')) {
            throw $this->createAccessDeniedException("Nie posiadasz odpowiednich uprawnień!");
        }

        $mem = new Mem();
        $mem->setCreatedBy($user);
        $mem->setIsAccepted(false);

        $form = $this->createForm(new AddMemType(), $mem);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->persist($mem);
            $this->addFlash('notice', "Mem został pomyślnie zapisany.");
            return $this->redirect($this->generateUrl('kwejk_mems_list'));
        }

        return $this->render('KwejkMemsBundle:Mems:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
