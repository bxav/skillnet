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

    public function get($resource, array $arg = [], array $params = [], $auth = null, $collection = false)
    {
        return $this->request('GET', $resource, $arg, $params, $auth, $collection);
    }

    public function getList($resource, array $arg = [], array $params = [], $auth = null, $collection = true)
    {
        return $this->request('GET', $resource, $arg, $params, $auth, $collection);
    }

    protected function request($word, $resource, $arg , $params, $auth, $collection)
    {

        $query = http_build_query($params);

        $endPoint = $this->classToResourceMapper->getPath($resource, $arg);

        $auth = $auth ? $auth : [$this->userId, $this->apiKey];

        dump($endPoint, $query);
        $body = (string) $this->client->request($word, $this->apiUrl . $endPoint . '?'. $query, [
            'auth' => $auth
        ])->getBody();

        if ($collection) {
            return $this->serializer->deserialize($body, $this->classToResourceMapper->getDeserializationType($resource, true), 'json');
        } else {
            return $this->serializer->deserialize($body, $this->classToResourceMapper->getDeserializationType($resource, false), 'json');
        }
    }
}
