<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GlownyController extends Controller
{
    /**
     * @Route("/index", name="indexowy")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Glowny:index.html.twig', array(
            // ...
        ));
    }

}
