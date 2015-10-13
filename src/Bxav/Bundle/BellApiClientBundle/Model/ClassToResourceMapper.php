<?php
namespace Bxav\Bundle\BellApiClientBundle\Model;

class ClassToResourceMapper
{


    protected $mapperResourceToClass = [];

    public function addClassToResoureMapping($class, $resource, $key = '') {
        $this->mapperResourceToClass[$resource]['name'] = $class;
        $this->mapperResourceToClass[$resource]['key'] = $key;
    }

    function getClass($resource, $collection = true) {
        $resource = $this->mapperResourceToClass[$resource];
        if ($collection) {
            $key = $resource['key'] !== '' ? $resource['key'] . ',' : '';
            $type = 'array<'.$key.''.$resource['name'].'>';
        } else {
            $type = $resource['name'];
        }

        return $type;
    }
}
