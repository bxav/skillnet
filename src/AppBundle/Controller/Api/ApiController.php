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
        $this->denyAccessUnlessGranted();
        $view = $this->view($object, $code);
        $view->setSerializationContext(SerializationContext::create()->setGroups(['Default', 'read']));
        return $this->handleView($view);
    }

    /**
     * @deprecated
     */
    protected function hydrateWithRequest(Request $request, $type)
    {
        $data = $request->getContent();
        $context = DeserializationContext::create()->setGroups(['Default', 'write']);
        $object = $this->get("serializer")->deserialize($data, $type, 'json', $context);

        return $object;
    }

    /**
     * @deprecated
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
                if (method_exists($object, $getterMethod) && method_exists($object->{$getterMethod}(), 'getId')) {
                    if (!is_null($method->getParameters()[0]->getClass())) {
                        $repository = $method->getParameters()[0]->getClass()->getName();
                    } else {
                        throw new \Exception("Method $setterMethod not typed");
                    }
                    if (method_exists($object->{$getterMethod}(), 'getId') && !is_null($object->{$getterMethod}()->getId())) {
                        $object->{$setterMethod}($this->getDoctrine()->getRepository($repository)->find($object->{$getterMethod}()->getId()));
                    } else {
                        throw new \Exception("Method getId not declared or return null");
                    }
                }
            }
        }
    }

    /**
     * @deprecated
     */
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

    /**
     * @deprecated
     */
    protected function deserializeRequest(Request $request)
    {
        return json_decode($request->getContent(), true);
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
     * @deprecated
     */
    protected function post(Request $request, $inject = null) {
        $object = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($object);

        //inject dependencies
        if (is_array($inject)) {
            foreach ($inject as $key => $objectToInject) {
                $setterMethod = 'set'.ucfirst($key);
                if(method_exists($object, $setterMethod)) {
                    $object->{$setterMethod}($objectToInject);
                }
            }
        }

        $this->persistAndFlush($object);

        return $this->createView($object, 201);
    }

    /**
     * @deprecated
     */
    protected function postUser(Request $request, $userManager) {
        $user = $userManager->createUser();

        $userFromRequest = $this->hydrateWithRequest($request, $this->getClass());
        $this->resolvePartialNestedEntity($userFromRequest);

        $user = $this->patchWithSameTypeObject($user, $userFromRequest);


        $userManager->updateUser($user);


        return $this->createView($user, 201);
    }

    /**
     * @deprecated
     */
    protected function put(Request $request, $object) {
        $objectFromRequest = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($objectFromRequest);

        $updatedObject = $this->patchWithSameTypeObject($object, $objectFromRequest);

        $this->persistAndFlush($updatedObject);

        return $this->createView($updatedObject, 200);
    }

    /**
     * @deprecated
     */
    protected function putUser(Request $request, $user, $userManager) {
        $userFromRequest = $this->hydrateWithRequest($request, $this->getClass());
        $this->resolvePartialNestedEntity($userFromRequest);

        $user = $this->patchWithSameTypeObject($user, $userFromRequest);

        $userManager->updateUser($user);

        return $this->createView($user, 200);
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
