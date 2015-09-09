<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;


class CustomerController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection Customer",
     * )
     */
    public function cgetAction()
    {
        $customers = $this->getDoctrine()->getRepository("AppBundle:Customer")->findAll();

        $view = $this->view($customers, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a Customer",
     * )
     */
    public function getAction($username)
    {
        $customer = $this->getDoctrine()->getRepository("AppBundle:Customer")->findOneByUsername($username);

        $view = $this->view($customer, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a customer",
     *  input="AppBundle\Entity\Booking",
     * )
     */
    public function postAction(Request $request)
    {

        $data = $request->getContent();

        $customer = $this->get("serializer")->deserialize($data, 'AppBundle\Entity\Customer', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();

        $view = $this->view($customer, 201);
        return $this->handleView($view);
    }
}
