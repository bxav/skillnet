<?php
namespace Bxav\Bundle\BellApiClientBundle\Model;

use GuzzleHttp\Client;

class BellApiClient
{

    protected $client;
    
    protected $apiUrl;
    
    protected $userId;
    
    protected $apiKey;
    
    public function __construct(Client $client, $apiUrl, $userId, $apiKey)
    {
        $this->client = $client;
        $this->apiUrl = $apiUrl;
        $this->userId = $userId;
        $this->apiKey = $apiKey;
    }

    public function get($resource, array $params = [])
    {
        return $this->request('GET', $resource, $params);
    }

    public function post($resource, array $params = [])
    {
        return $this->request('POST', $resource, $params);
    }
    
    protected function request($word, $resource, $params)
    {

        $query = http_build_query($params);

        return $this->client->request($word, $this->apiUrl . '/' . $resource . '?'. $query, [
            'auth' => [$this->userId, $this->apiKey]
        ])->getBody();
    }
}
