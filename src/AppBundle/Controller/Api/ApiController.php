<?php

namespace AppBundle\Controller\Api;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;


Abstract class ApiController extends ResourceController
{
    /**
     * The class name managed by the controller class.
     *
     * @var string
     */
    protected $class = '';

    /**
     * @deprecated
     */
    protected function createView($object, $code)
    {
        $view = $this->view($object, $code);
        $view->setSerializationContext(SerializationContext::create()->setGroups(['Default', 'read']));
        return $this->handleView($view);
    }

    /**
     * @deprecated
     */
    protected function persistAndFlush($object)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @deprecated
     */
    protected function getClass() {
        if (is_null($this->class)) {
            throw new \Exception("Class not set");
        } else {
            return $this->class;
        }
    }
}
