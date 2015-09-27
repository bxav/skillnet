<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Employee;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;


class EmployeeController extends ApiController implements ClassResourceInterface
{

    protected $class = 'AppBundle\Entity\Employee';

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
     *  description="Return a collection of Employee",
     * )
     * @QueryParam(name="current", requirements="(true|false)+", description="Get the current authenticated user")
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
     *  output="\AppBundle\Entity\Employee",
     *  statusCodes={
     *      200="Returned if everything is fine",
     *      404="Returned if the slug of the employee does not exists"
     *  },
     *  description="Return an Employee",
     * )
     */
    public function getAction(Employee $employee)
    {
        return $this->createView($employee, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine",
     *      404="Returned if the slug of the employee does not exists"
     *  },
     *  description="Return a collection of Service",
     * )
     */
    public function getServicesAction(Employee $employee)
    {
        return $this->createView($employee->getServices(), 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
     *  description="Create an Employee",
     * )
     */
    public function postAction(Request $request)
    {
        return $this->postUser($request);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a Employee",
     * )
     */
    public function putAction(Request $request, Employee $employee)
    {
        return $this->putUser($request, $employee);
    }
}
