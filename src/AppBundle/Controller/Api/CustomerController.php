<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class CustomerController extends ApiController
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

        return $this->createView($customers, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a Customer",
     * )
     * @ParamConverter("customer", options={"mapping": {"customer": "username"}})
     */
    public function getAction(Customer $customer)
    {
        return $this->createView($customer, 200);
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

        return $this->createView($customer, 201);
    }
}
