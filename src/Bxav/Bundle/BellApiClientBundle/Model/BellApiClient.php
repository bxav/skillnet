<?php
namespace Bxav\Bundle\BellApiClientBundle\Model;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class BellApiClient
{

    protected $client;

    protected $serializer;

    protected $classToResourceMapper;

    protected $apiUrl;
    
    protected $userId;
    
    protected $apiKey;
    
    public function __construct(Client $client, Serializer $serializer, ClassToResourceMapper $classToResourceMapper, $apiUrl, $userId, $apiKey)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->classToResourceMapper = $classToResourceMapper;
        $this->apiUrl = $apiUrl;
        $this->userId = $userId;
        $this->apiKey = $apiKey;
    }

    public function get($resource, array $arg = [], array $params = [], $simple = true)
    {
        return $this->request('GET', $resource, $arg, $params, $simple);
    }

    protected function request($word, $resource, $arg , $params, $simple)
    {

        $query = http_build_query($params);

        if ($arg !== []) {
            $resourceTemp = $resource . '/' . $arg[0];
        } else {
            $resourceTemp = $resource;
        }


        $body = (string) $this->client->request($word, $this->apiUrl . '/' . $resourceTemp . '?'. $query, [
            'auth' => [$this->userId, $this->apiKey]
        ])->getBody();


        if (!$simple) {
            preg_match('/([a-zA-Z-]*)$/', $resource, $matches);
            $resource = $matches[0];
        }

        if ($arg == []) {
            return $this->serializer->deserialize($body, $this->classToResourceMapper->getClass($resource), 'json');
        } else {
            return $this->serializer->deserialize($body, $this->classToResourceMapper->getClass($resource, false), 'json');
        }
    }
}
