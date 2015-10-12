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

    public function get($resource, array $params = [])
    {
        return $this->request('GET', $resource, $params);
    }

    protected function request($word, $resource, $params)
    {

        $query = http_build_query($params);

        $body = (string) $this->client->request($word, $this->apiUrl . '/' . $resource . '?'. $query, [
            'auth' => [$this->userId, $this->apiKey]
        ])->getBody();

        return $this->serializer->deserialize($body, 'array<'.$this->classToResourceMapper->getClass($resource).'>', 'json');
    }
}
