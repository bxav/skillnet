<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Test;

use Sylius\Component\Rbac\Authorization\AuthorizationCheckerInterface;

class AuthorizationChecker implements AuthorizationCheckerInterface
{
    /**
     * {@inheritdoc}
     */
    public function isGranted($permissionCode)
    {
        return true;
    }
}
