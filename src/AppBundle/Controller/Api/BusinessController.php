<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Business;
use AppBundle\Form\Type\BusinessType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


class BusinessController extends ApiController
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Business",
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
     *  requirements={
     *      {
     *          "name"="business",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Business's slug"
     *      }
     *  },
     *  description="Return a Business",
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
     *  requirements={
     *      {
     *          "name"="business",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Business's slug"
     *      }
     *  },
     *  description="Return a collection of Employee",
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
     *  requirements={
     *      {
     *          "name"="business",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Business's slug"
     *      }
     *  },
     *  description="Return a collection of Service",
     * )
     * @ParamConverter("business", options={"mapping": {"business": "slug"}})
     */
    public function getServicesAction(Business $business)
    {
        return $this->createView($business->getServices(), 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      201="Returned if business created successfully"
     *  },
     *  description="Create a Business",
     *  input="AppBundle\Entity\Business",
     * )
     */
    public function postAction(Request $request)
    {
        $business = $this->hydrateWithRequest($request, 'AppBundle\Entity\Business');

        $this->persistAndFlush($business);

        return $this->createView($business, 201);
    }
}
