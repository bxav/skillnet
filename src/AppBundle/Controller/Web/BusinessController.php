<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Booking;
use AppBundle\Entity\Business;
use AppBundle\Entity\Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BusinessController extends Controller
{

    /**
     * @Route("/checkout/final", name="checkout_final_page")
     */
    public function checkoutFinalAction(Request $request)
    {
        $date = new \DateTimeImmutable($request->get("date")['date'], new \DateTimeZone($request->get("date")['timezone']));
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($request->get("service"));
        $employee = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($request->get("employee"));

        $personalizedService = $this->getDoctrine()->getRepository('AppBundle:PersonalizedService')->findOneBy(['customer' => $this->getUser(), 'service' => $service]);

        $price = null;
        $startTime = clone $date;
        $endTime = null;
        $isPersonalized = false;
        if ($personalizedService) {
            $price = $personalizedService->getPrice();
            $endTime = $date->add(new \DateInterval('PT' . $personalizedService->getDuration() . 'M'));
            $isPersonalized = true;
        }

        $price = $price ?  : $service->getPrice();
        $endTime = $endTime ? $endTime : $date->add(new \DateInterval('PT'.$service->getDuration().'M'));

        $booking = new Booking();
        $booking->setPrice($price);
        $booking->setPersonalized($isPersonalized);
        $booking->setCustomer($this->getUser());
        $booking->setService($service);
        $booking->setStartDatetime($startTime);
        $booking->setEmployee($employee);
        $booking->setEndDatetime($endTime);

        $em = $this->getDoctrine()->getManager();
        $em->persist($booking);
        $em->flush();
        //@todo check availability before registering the booking
        return $this->redirect($this->generateUrl('my_bookings'));
    }

    /**
     * @Route("/checkout", name="checkout_page")
     */
    public function checkoutAction(Request $request)
    {
        $date = new \DateTimeImmutable($request->get("date")['date'], new \DateTimeZone($request->get("date")['timezone']));
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($request->get("service"));
        $employees = [];
        foreach($request->get("employees") as $employeeId ) {
            $employees[] = $this->getDoctrine()->getRepository('AppBundle:Employee')->find($employeeId);
        }

        return $this->render(':Business:checkout.html.twig', [
            'date' => $date,
            'service' => $service,
            'employees' => $employees
        ]);
    }



    /**
     * @Route("/{businessSlug}", name="business_page")
     * @ParamConverter("business", options={"mapping": {"businessSlug": "slug"}})
     */
    public function indexAction(Request $request, Business $business)
    {
        $date = new \DateTimeImmutable($request->get("date"));
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
