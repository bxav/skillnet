<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Employee;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class EmployeeController extends ApiController
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Employees",
     * )
     * @QueryParam(name="current", requirements="(true|false)+", description="Employee's slug.")
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        if ($paramFetcher->get('current') == 'true') {
            $user = $this->getUser();
            $employees = $this->getDoctrine()->getRepository("AppBundle:Employee")->find($user->getId());
        } else {
            $employees = $this->getDoctrine()->getRepository("AppBundle:Employee")->findAll();
        }

        return $this->createView($employees, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return an employee",
     * )
     * @ParamConverter("employee", options={"mapping": {"employee": "slug"}})
     */
    public function getAction(Employee $employee)
    {
        return $this->createView($employee, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of employee's services",
     * )
     * @ParamConverter("employee", options={"mapping": {"employee": "slug"}})
     */
    public function getServicesAction(Employee $employee)
    {
        return $this->createView($employee->getServices(), 200);
    }
}
