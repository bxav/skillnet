<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;


class EmployeeController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Employees",
     * )
     */
    public function cgetAction()
    {
        $employees = $this->getDoctrine()->getRepository("AppBundle:Employee")->findAll();


        $view = $this->view($employees, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of employee's services",
     * )
     */
    public function getServicesAction($firstname)
    {
        $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->findOneBy([
            "firstname" => $firstname
        ]);

        $view = $this->view($employee->getServices(), 200);

        return $this->handleView($view);
    }
}
