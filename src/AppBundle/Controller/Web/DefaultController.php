<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{


    /**
     * @Route("/pro", name="pro")
     */
    public function proAction()
    {
        return $this->render('::pro.html.php', []);
    }
    
    /**
     * @Route("/{businessSlug}", name="homepage")
     */
    public function indexAction($businessSlug = null)
    {
        $business = $this->getDoctrine()->getRepository('AppBundle:Business')->findOneBySlug($businessSlug);
        if ($business) {
            return $this->render('default/show.html.twig', ['business' => $business]);
        } else {
            $businesses = $this->getDoctrine()->getRepository('AppBundle:Business')->findAll();
            return $this->render('default/index.html.twig', ['businesses' => $businesses]);
        }
    }
}
