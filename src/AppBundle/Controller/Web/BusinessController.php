<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BusinessController extends Controller
{

    /**
     * @Route("/{businessSlug}", name="business_page")
     */
    public function indexAction(Request $request, $businessSlug)
    {
        $date = new \DateTimeImmutable($request->get("date"));
        $business = $this->getDoctrine()->getRepository('AppBundle:Business')->findOneBySlug($businessSlug);
        if ($request->get("service")) {
            $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['business' => $business, 'type' => $request->get("service")]);
        } else {
            $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['business' => $business]);
        }
        $availabilities = $this->get("app.availability.finder")->findByDateAndService($date, $service);
        return $this->render(':Business:show.html.twig', [
            'business' => $business,
            'availabilities' => $availabilities,
            'date' => $date
        ]);
    }
}
