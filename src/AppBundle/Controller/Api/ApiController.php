<?php

namespace AppBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;


Abstract class ApiController extends FOSRestController implements ClassResourceInterface
{
    protected function createView($object, $code)
    {
        $view = $this->view($object, $code);

        return $this->handleView($view);
    }
}
