<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function availabilityAction(Request $request)
    {
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($request->get('serviceId'));
        $availabilities = $this->get("app.availability.finder")->findByDateAndService(new \DateTimeImmutable(), $service);
        return $this->render('Business/availabilityCalendar.html.twig', ['availabilities' => $availabilities]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $businesses = $this->getDoctrine()->getRepository('AppBundle:Business')->findAll();
        return $this->render('Business/index.html.twig', ['businesses' => $businesses]);
    }
}
