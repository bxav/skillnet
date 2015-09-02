<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/availability", name="availability")
     */
    public function availabilityAction()
    {
        $availability = ['9:30', '10:00', '12:00'];
        return new JsonResponse($availability);
    }

    /**
     * @Route("/{businessSlug}", name="homepage")
     */
    public function indexAction($businessSlug = null)
    {
        $business = $this->getDoctrine()->getRepository('AppBundle:Business')->findOneBySlug($businessSlug);
        if ($business) {
            return $this->render('Business/show.html.twig', ['business' => $business]);
        } else {
            $businesses = $this->getDoctrine()->getRepository('AppBundle:Business')->findAll();
            return $this->render('Business/index.html.twig', ['businesses' => $businesses]);
        }
    }
}
