<?php

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class AssetVersionHelper extends Helper
{
    private $assetVersionResolver;

    public function __construct($assetVersionResolver)
    {
        $this->assetVersionResolver = $assetVersionResolver;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('asset_version', array($this, 'getAssetVersion')),
        );
    }
    public function getAssetVersion($filename)
    {
        return $this->assetVersionResolver->getAssetVersion($filename);
    }

    public function getName()
    {
        return 'asset_version';
    }
}
