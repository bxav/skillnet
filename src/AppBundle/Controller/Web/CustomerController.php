<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{

    /**
     * @Route("/my-bookings", name="my_bookings")
     */
    public function myBookingAction()
    {
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->findOneById($this->getUser());
        $bookings = $this->getDoctrine()->getRepository("AppBundle:Booking")->findByCustomer($customer);
        return $this->render(':Customer:my_bookings.html.twig', ['bookings' => $bookings]);
    }
}
