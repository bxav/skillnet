<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;


class BookingController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Bookings",
     * )
     * @QueryParam(name="employee", requirements="[a-z]+", description="Employee's firstname.")
     *
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->findOneByFirstname($paramFetcher->get('employee'));
        $booking = $this->getDoctrine()->getRepository("AppBundle:Booking")->findAllByEmployee($employee);

        $view = $this->view($booking, 200);

        return $this->handleView($view);
    }
}
