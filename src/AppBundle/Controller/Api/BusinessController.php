<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Business;
use AppBundle\Form\Type\BusinessType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;


class BusinessController extends ApiController implements ClassResourceInterface
{

    protected $class = 'AppBundle\Entity\Business';

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Business",
     * )
     */
    public function cgetAction()
    {
        $business = $this->getDoctrine()->getRepository($this->class)->findAll();

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
        return $this->post($request);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a business",
     * )
     */
    public function putAction(Request $request, Business $business)
    {
        return $this->put($request, $business);
    }
}
