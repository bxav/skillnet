<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        return $this->render('::contact.html.twig');
    }

    /**
     * @Route("/availability", name="availability")
     */
    public function availabilityAction(Request $request)
    {
        $date = new \DateTimeImmutable($request->get("date"));
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($request->get('serviceId'));
        $availabilities = $this->get("app.availability.finder")->findByDateAndService($date, $service);
        return $this->render(':Business:availability_calendar.html.twig', ['availabilities' => $availabilities, 'date' => $date]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $businesses = $this->getDoctrine()->getRepository('AppBundle:Business')->findAll();
        return $this->render(':Business:index.html.twig', ['businesses' => $businesses]);
    }
}
