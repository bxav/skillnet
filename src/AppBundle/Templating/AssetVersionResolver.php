<?php

namespace AppBundle\Templating;

class AssetVersionResolver
{

    private $appDir;

    public function __construct($appDir)
    {
        $this->appDir = $appDir;
    }

    public function getAssetVersion($filename)
    {
        $manifestPath = $this->appDir.'/Resources/assets/rev-manifest.json';
        if (!file_exists($manifestPath)) {
            throw new \Exception(sprintf('Cannot find manifest file: "%s"', $manifestPath));
        }

        $paths = json_decode(file_get_contents($manifestPath), true);

        if (!isset($paths[$filename]) && $filename[0] === '/') {
            $filename = substr($filename, 1);
        }

        if (!isset($paths[$filename])) {
            throw new \Exception(sprintf('There is no file "%s" in the version manifest!', $filename));
        }
        return '/' . $paths[$filename];
    }
}
