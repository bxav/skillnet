<?php

use Guzzle\Http\Message\Request;
use Knp\FriendlyContexts\Builder\RequestBuilder;
use Guzzle\Http\Client;

class Oauth2Extension implements \Knp\FriendlyContexts\Http\Security\SecurityExtensionInterface
{
    private $oauthPluginFactory;

    public function __construct()
    {
        $this->oauthPluginFactory = new Oauth2PluginFactory;
    }

    public function secureClient(Client $client, RequestBuilder $builder)
    {
        $plugin = $this->oauthPluginFactory->create($builder->getCredentials());

        $client->addSubscriber($plugin);
    }

    public function secureRequest(Request $request, RequestBuilder $builder)
    {
    }
}
