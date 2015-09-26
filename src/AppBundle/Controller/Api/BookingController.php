<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Booking;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;


class BookingController extends ApiController
{

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
        $booking = new Booking();

        //$context = new \JMS\Serializer\DeserializationContext();
        //$context->attributes->set('target', $booking);

        $booking = $this->hydrateWithRequest($request, 'AppBundle\Entity\Booking');

        $this->resolvePartialNestedEntity($booking);

        $this->persistAndFlush($booking);

        return $this->createView($booking, 201);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a booking",
     *  input="AppBundle\Entity\Booking",
     * )
     */
    public function putAction(Request $request, Booking $booking)
    {

        $bookingFromRequest = $this->hydrateWithRequest($request, 'AppBundle\Entity\Booking');

        $this->resolvePartialNestedEntity($bookingFromRequest);

        $updatedBooking = $this->patchWithSameTypeObject($booking, $bookingFromRequest);

        $this->persistAndFlush($updatedBooking);

        return $this->createView($updatedBooking, 200);
    }
}
