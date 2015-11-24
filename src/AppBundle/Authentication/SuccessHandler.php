<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Authentication;

use Symfony\Component\Routing\RouterInterface,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;

    protected $backEndRoles = [];

    protected $appProRoles = [];

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function setBackendUserRoles(array $roles)
    {
        $this->backEndRoles = $roles;
    }

    public function setAppProUserRoles(array $roles)
    {
        $this->appProRoles = $roles;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($this->isABackendUser($token->getUser())) {
            return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
        } else if ($this->isAnAppProUser($token->getUser())) {
            return new RedirectResponse($this->router->generate('homepage'));
        } else {
            return new RedirectResponse($this->router->generate('homepage'));
        }
    }

    protected function isABackendUser($user)
    {
        $roles = $user->getRoles();
        $roles = array_intersect($this->backEndRoles, $roles);
        return (bool) $roles;
    }

    protected function isAnAppProUser($user)
    {
        $roles = $user->getRoles();
        $roles = array_intersect($this->appProRoles, $roles);
        return (bool) $roles;
    }
}

