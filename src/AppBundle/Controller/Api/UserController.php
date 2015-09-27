<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;


class UserController extends ApiController implements ClassResourceInterface
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

        return $this->createView($users, 200);

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

        return $this->createView($user, 200);
    }
}
