<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;


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
}
