<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Routing\ClassResourceInterface;


class CustomerController extends ApiController implements ClassResourceInterface
{

    protected $class = 'AppBundle\Entity\Customer';

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
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
     *  requirements={
     *      {
     *          "name"="customer",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Customer's username"
     *      }
     *  },
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
     *  description="Return a Customer",
     * )
     */
    public function getAction(Customer $customer)
    {
        return $this->createView($customer, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
     *  description="Create a Customer",
     * )
     */
    public function postAction(Request $request)
    {
        $userManager = $this->container->get('app.user.user_manager.customer');

        return $this->postUser($request, $userManager);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a Customer",
     * )
     */
    public function putAction(Request $request, Customer $customer)
    {
        $userManager = $this->container->get('app.user.user_manager.customer');

        return $this->putUser($request, $customer, $userManager);
    }
}
