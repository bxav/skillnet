<?php

namespace AppBundle\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;


Abstract class ApiController extends FOSRestController implements ClassResourceInterface
{
    /**
     * The class name managed by the controller class.
     *
     * @var string
     */
    protected $class = '';

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
        $class = new \ReflectionClass(get_class($objectToPatch));
        $methods = $class->getMethods();
        foreach($methods as $method) {
            if ((strpos($method->getName(), 'set') !== false)) {
                $setterMethod = $method->getName();
                $getterMethod = $setterMethod;
                $getterMethod[0] = 'g';
                if (method_exists($object, $getterMethod) && $object->{$getterMethod}() != null) {
                    $objectToPatch->{$setterMethod}($object->{$getterMethod}());
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

    protected function post(Request $request) {
        $object = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($object);

        $this->persistAndFlush($object);

        return $this->createView($object, 201);
    }

    protected function put(Request $request, $object) {
        $objectFromRequest = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($objectFromRequest);

        $updatedObject = $this->patchWithSameTypeObject($object, $objectFromRequest);

        $this->persistAndFlush($updatedObject);

        return $this->createView($updatedObject, 200);
    }

    protected function getClass() {
        if (is_null($this->class)) {
            throw new \Exception("Class not set");
        } else {
            return $this->class;
        }
    }
}
