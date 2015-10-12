<?php
namespace Bxav\Bundle\BellApiClientBundle\Model;

class ClassToResourceMapper
{

    protected $mapperClassToResource = [];

    protected $mapperResourceToClass = [];

    public function addClassToResoureMapping($class, $resource) {
        $this->mapperClassToResource[$class] = $resource;
        $this->mapperResourceToClass[$resource] = $class;
    }

    function getResource($class) {
        return $this->mapperClassToResource[$class];
    }

    function getClass($resource) {
        return $this->mapperResourceToClass[$resource];
    }
}
