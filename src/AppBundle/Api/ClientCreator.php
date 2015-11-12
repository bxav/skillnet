<?php

namespace AppBundle\Api;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;

class ClientCreator
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