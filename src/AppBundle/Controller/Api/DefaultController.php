<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="api_resource")
     * @Method("GET")
     */
    public function indexAction()
    {
        $obj = new \stdClass();
        $obj->say = ["Hello", "World!!"];
        return new JsonResponse($obj);
    }
}
