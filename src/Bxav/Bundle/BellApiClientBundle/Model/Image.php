<?php

namespace Bxav\Bundle\BellApiClientBundle\Model;

class Image
{

    protected $realPath;

    /**
     * @return mixed
     */
    public function getRealPath()
    {
        return $this->realPath;
    }

    /**
     * @param mixed $realPath
     */
    public function setRealPath($realPath)
    {
        $this->realPath = $realPath;
    }
}
