<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Business;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class BusinessController extends FOSRestController implements ClassResourceInterface
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


        $view = $this->view($business, 200);

        return $this->handleView($view);
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

        $view = $this->view($business, 200);

        return $this->handleView($view);
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

        $view = $this->view($employees, 200);

        return $this->handleView($view);
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
        $view = $this->view($business->getServices(), 200);

        return $this->handleView($view);
    }
}
