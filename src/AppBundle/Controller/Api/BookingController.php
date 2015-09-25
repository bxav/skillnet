<?php

namespace AppBundle\Controller\Api;

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

        $data = $request->getContent();

        $booking = $this->get("serializer")->deserialize($data, 'AppBundle\Entity\Booking', 'json');

        //@todo so ugly
        $booking->setCustomer($this->getDoctrine()->getRepository("AppBundle:Customer")->findOneByUsername(json_decode($data)->customer_username));
        $booking->
        setEmployee($this->getDoctrine()->getRepository("AppBundle:Employee")->findOneBySlug(json_decode($data)->employee_slug));
        if(isset(json_decode($data)->service_id)) {
            $booking->setService($this->getDoctrine()->getRepository("AppBundle:Service")->find(json_decode($data)->service_id));
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($booking);
        $em->flush();

        return $this->createView($booking, 201);
    }
}
