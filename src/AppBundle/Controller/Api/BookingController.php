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
        if ($employee) {
            $booking = $this->getDoctrine()->getRepository("AppBundle:Booking")->findByEmployee($employee);
        } else {
            $booking = $this->getDoctrine()->getRepository("AppBundle:Booking")->findAll();
        }
        $view = $this->view($booking, 200);

        return $this->handleView($view);
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

        $view = $this->view($booking, 201);
        return $this->handleView($view);
    }
}
