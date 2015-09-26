<?php

namespace AppBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;


Abstract class ApiController extends FOSRestController implements ClassResourceInterface
{
    protected function createView($object, $code)
    {
        $view = $this->view($object, $code);

        return $this->handleView($view);
    }

    protected function hydrateWithRequest(Request $request, $type, $context = null)
    {
        $data = $request->getContent();
        $object = $this->get("serializer")->deserialize($data, $type, 'json', $context);

        return $object;
    }

    /**
     * Todo find a better way or wait for an improvement on serializer and doctrine
     */
    protected function resolvePartialNestedEntity($object)
    {
        $class = new \ReflectionClass(get_class($object));
        $methods = $class->getMethods();
        foreach($methods as $method) {
            if ((strpos($method->getName(), 'set') !== false)) {
                $setterMethod = $method->getName();
                $getterMethod = $setterMethod;
                $getterMethod[0] = 'g';
                if (method_exists($object->{$getterMethod}(), 'getId')) {
                    $repository = $method->getParameters()[0]->getClass()->getName();
                    $object->{$setterMethod}($this->getDoctrine()->getRepository($repository)->find($object->{$getterMethod}()->getId()));
                }
            }
        }
    }

    protected function patchWithSameTypeObject($objectToPatch, $object)
    {
        if (get_class($objectToPatch) === get_class($object)) {
            $class = new \ReflectionClass(get_class($object));
            $methods = $class->getMethods();
            foreach($methods as $method) {
                if ((strpos($method->getName(), 'set') !== false)) {
                    $setterMethod = $method->getName();
                    $getterMethod = $setterMethod;
                    $getterMethod[0] = 'g';
                    if ($object->{$getterMethod}() != null) {
                        $objectToPatch->{$setterMethod}($object->{$getterMethod}());
                    }
                }
            }
        }
        return $objectToPatch;

    }

    protected function deserializeRequest(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    protected function persistAndFlush($object)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
    }
}
