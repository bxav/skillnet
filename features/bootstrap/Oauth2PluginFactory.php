<?php

use Guzzle\Http\Client;
use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;
use CommerceGuys\Guzzle\Plugin\Oauth2\GrantType\PasswordCredentials;
use CommerceGuys\Guzzle\Plugin\Oauth2\GrantType\RefreshToken;

class Oauth2PluginFactory
{
    public function create(array $data = [])
    {

        $oauth2Client = new Client($data['token_url']);

        $grantType = new PasswordCredentials($oauth2Client, $data);
        $refreshTokenGrantType = new RefreshToken($oauth2Client, $data);
        $oauth2Plugin = new Oauth2Plugin($grantType, $refreshTokenGrantType);

        return $oauth2Plugin;
    }
}
