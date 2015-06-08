<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/{message}", name="homepage")
     */
    public function indexAction($message = 'hello')
    {
        return $this->render('default/index.html.twig', ['helloMessage' => $message]);
    }
}
