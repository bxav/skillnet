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
     * @Route("/my-bookings", name="my_bookings")
     */
    public function myBookingAction()
    {
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->findOneById($this->getUser());
        $bookings = $this->getDoctrine()->getRepository("AppBundle:Booking")->findByCustomer($customer);
        return $this->render('Customer/myBookings.html.twig', ['bookings' => $bookings]);
    }

    /**
     * @Route("/availability", name="availability")
     */
    public function availabilityAction(Request $request)
    {
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($request->get('serviceId'));
        $availabilities = $this->get("app.availability.finder")->findByDateAndService(new \DateTimeImmutable(), $service);
        return new JsonResponse($availabilities);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $businesses = $this->getDoctrine()->getRepository('AppBundle:Business')->findAll();
        return $this->render('Business/index.html.twig', ['businesses' => $businesses]);
    }

    /**
     * @Route("/{businessSlug}", name="business_page")
     */
    public function indexBusinessAction(Request $request, $businessSlug)
    {
        $business = $this->getDoctrine()->getRepository('AppBundle:Business')->findOneBySlug($businessSlug);
        if ($request->get("service")) {
            $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['business' => $business, 'type' => $request->get("service")]);
        } else {
            $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['business' => $business]);
        }
        $availabilities = $this->get("app.availability.finder")->findByDateAndService(new \DateTimeImmutable(), $service);
        return $this->render('Business/show.html.twig', [
            'business' => $business,
            'availabilities' => $availabilities
        ]);
    }
}
