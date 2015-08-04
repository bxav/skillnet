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
     *  description="Return an employee",
     * )
     */
    public function getAction($slug)
    {
        if($slug === "current") {
            $user = $this->getUser();
            $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->find($user->getId());
        } else {
            $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->findOneBySlug($slug);
        }

        $view = $this->view($employee, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of employee's services",
     * )
     */
    public function getServicesAction($slug)
    {
        $employee = $this->getDoctrine()->getRepository("AppBundle:Employee")->findOneBySlug($slug);

        $view = $this->view($employee->getServices(), 200);

        return $this->handleView($view);
    }
}
