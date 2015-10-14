<?php
namespace Bxav\Bundle\BellApiClientBundle\Model;

class ClassToResourceMapper
{


    protected $mapperResourceToClass = [];

    public function addClassToResoureMapping($resource, $class, $path, $key = '') {
        $this->mapperResourceToClass[$resource]['name'] = $class;
        $this->mapperResourceToClass[$resource]['path'] = $path;
        $this->mapperResourceToClass[$resource]['key'] = $key;
    }

    public function getDeserializationType($resource, $collection = true) {
        $resource = $this->mapperResourceToClass[$resource];
        if ($collection) {
            $key = $resource['key'] !== '' ? $resource['key'] . ',' : '';
            $type = 'array<'.$key.''.$resource['name'].'>';
        } else {
            $type = $resource['name'];
        }

        return $type;
    }

    public function getPath($resource, $args)
    {
        $resources = $this->mapperResourceToClass[$resource]['path'];
        $endPoint = '';
        foreach ($resources as $resource) {
            $argName = $this->gerArgumentName($resource);
            dump($argName, $args);
            if (isset($args[$argName])) {
                $endPoint = $endPoint . '/' . $args[$argName];
            } elseif ($argName == null) {
                $endPoint = $endPoint . '/' . $resource;
            }
        }

        return $endPoint;
    }

    private function gerArgumentName($resource) {
        preg_match('/({([a-zA-Z-]*)})/', $resource, $matches);
        return isset($matches[2]) ? $matches[2] : null;
    }
}
