<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Employee;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;


class CurrentCustomerController extends ApiController
{

    protected $class = 'AppBundle\Entity\Customer';

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine",
     *      404="Returned if the slug of the employee does not exists"
     *  },
     *  description="Return an Customer",
     * )
     */
    public function getCurrentCustomerAction()
    {
        $customer = $this->getUser();
        return $this->createView($customer, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a Customer",
     * )
     */
    public function putCurrentCustomerAction(Request $request)
    {
        $customer = $this->getUser();
        $userManager = $this->container->get('app.user.user_manager.customer');

        return $this->putUser($request, $customer, $userManager);
    }
}
