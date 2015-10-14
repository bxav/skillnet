<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Booking;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;


class BookingController extends ApiController implements ClassResourceInterface
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
     * @QueryParam(name="customer-id", requirements="\d+", description="Customer's id.")
     * @QueryParam(name="employee", requirements="\d+", description="Employee's id.")
     *
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {

        $criteria = [];
        if ($paramFetcher->get('employee')) {
            $criteria['employee'] = $this->getDoctrine()->getRepository("AppBundle:Employee")->find($paramFetcher->get('employee'));
        }
        if ($paramFetcher->get('customer-id')) {
            $criteria['customer'] = $this->getDoctrine()->getRepository("AppBundle:Customer")->find($paramFetcher->get('customer-id'));
        }

        $booking = $this->getDoctrine()->getRepository("AppBundle:Booking")->findBy($criteria);



        return $this->createView($booking, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a booking",
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
