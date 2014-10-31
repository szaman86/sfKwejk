<?php

namespace Kwejk\MemsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RatingController extends Controller
{
    public function addRatingAction()
    {
        return $this->render('KwejkMemsBundle:Rating:addRating.html.twig', array(
                // ...
            ));    }

}
