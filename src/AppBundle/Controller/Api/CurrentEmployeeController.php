<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Employee;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;


class CurrentEmployeeController extends ApiController
{

    protected $class = 'AppBundle\Entity\Employee';

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
    public function getCurrentEmployeeAction()
    {
        $employee = $this->getUser();
        return $this->createView($employee, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a Employee",
     * )
     */
    public function putCurrentEmployeeAction(Request $request)
    {
        $employee = $this->getUser();
        return $this->putUser($request, $employee);
    }
}
