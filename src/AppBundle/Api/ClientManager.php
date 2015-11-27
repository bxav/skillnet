<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Api;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;

class ClientManager
{
    protected $clientManager;

    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    public function create()
    {
        $clientManager = $this->clientManager;
        /** @var Client $client */
        $client = $clientManager->createClient();
        $client->setAllowedGrantTypes(['password']);
        $clientManager->updateClient($client);

        return ['publicId' => $client->getPublicId(), 'secret' => $client->getSecret()];
    }
}
