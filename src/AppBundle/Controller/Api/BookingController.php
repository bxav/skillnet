<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;


class BookingController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Bookings",
     * )
     */
    public function cgetAction()
    {
        $booking = $this->getDoctrine()->getRepository("AppBundle:Booking")->findAll();

        $view = $this->view($booking, 200);

        return $this->handleView($view);
    }
}
