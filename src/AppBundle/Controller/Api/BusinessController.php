<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Business;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class BusinessController extends ApiController
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Users",
     * )
     */
    public function cgetAction()
    {
        $business = $this->getDoctrine()->getRepository("AppBundle:Business")->findAll();

        return $this->createView($business, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a business",
     * )
     * @ParamConverter("business", options={"mapping": {"business": "slug"}})
     */
    public function getAction(Business $business)
    {
        return $this->createView($business, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Users",
     * )
     * @ParamConverter("business", options={"mapping": {"business": "slug"}})
     */
    public function getEmployeesAction(Business $business)
    {
        $employees = $this->getDoctrine()->getRepository("AppBundle:Employee")->findByBusiness($business);

        return $this->createView($employees, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of services",
     * )
     * @ParamConverter("business", options={"mapping": {"business": "slug"}})
     */
    public function getServicesAction(Business $business)
    {
        return $this->createView($business->getServices(), 200);
    }
}
