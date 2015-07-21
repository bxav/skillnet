<?php

namespace AppBundle\Controller\Api;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;


class UserController extends FOSRestController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Users",
     * )
     */
    public function cgetAction()
    {
        $users = null;
        $users = $this->getDoctrine()->getRepository("AppBundle:User")->findAll();


        $view = $this->view($users, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Register an User",
     *  parameters={
     *      {"name"="username", "dataType"="string", "required"=true, "description"="username"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="email"},
     *      {"name"="password", "dataType"="string", "required"=true, "description"="plain password"}
     *  }
     * )
     */
    public function postAction(Request $request)
    {
        $data = $request->getContent();
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setUsername(json_decode($data)->username);
        $user->setEmail(json_decode($data)->email);
        $user->setPlainPassword(json_decode($data)->password);
        $userManager->updateUser($user);
        $view = $this->view($user, 200);

        return $this->handleView($view);
    }
}
