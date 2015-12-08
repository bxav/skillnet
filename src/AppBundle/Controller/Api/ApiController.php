<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Api;

use JMS\Serializer\SerializationContext;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ApiController extends ResourceController
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
    protected function getClass()
    {
        if (is_null($this->class)) {
            throw new \Exception('Class not set');
        } else {
            return $this->class;
        }
    }

    protected function isGrantedOr403($permission)
    {

        if (!($this->config->getParameters()->get('authentication') == false) && !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException(sprintf('Access denied to "%s" for "%s".', 'auth', $this->getUser() ? $this->getUser()->getUsername() : 'anon.'));
        }

        if (!$this->container->has('sylius.authorization_checker')) {
            return true;
        }

        $permission = $this->config->getPermission($permission);

        if ($permission) {
            $grant = sprintf('%s.%s.%s', $this->config->getBundlePrefix(), $this->config->getResourceName(), $permission);

            if (!$this->get('sylius.authorization_checker')->isGranted($grant)) {
                throw new AccessDeniedException(sprintf('Access denied to "%s" for "%s".', $grant, $this->getUser() ? $this->getUser()->getUsername() : 'anon.'));
            }
        }
    }
}
