<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Booking;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;


class BookingController extends ApiController
{

    protected $class = 'AppBundle\Entity\Booking';

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
     *  description="Return a collection of Booking",
     * )
     * @QueryParam(name="employee", requirements="[a-z-]+", description="Employee's slug.")
     *
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->findOneBySlug($paramFetcher->get('employee'));
        if ($employee) {
            $booking = $this->getDoctrine()->getRepository("AppBundle:Booking")->findByEmployee($employee);
        }

        return $this->createView($booking, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a booking",
     *  input="AppBundle\Entity\Booking",
     * )
     */
    public function postAction(Request $request)
    {
        return $this->post($request);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a booking",
     * )
     */
    public function putAction(Request $request, Booking $booking)
    {
        return $this->put($request, $booking);
    }
}
