<?php

namespace AppBundle\Templating\Twig;

class AssetVersionExtension extends \Twig_Extension
{
    private $assetVersionResolver;

    public function __construct($assetVersionResolver)
    {
        $this->assetVersionResolver = $assetVersionResolver;
    }

    public function getAssetVersion($filename)
    {
        return $this->assetVersionResolver->getAssetVersion($filename);
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('asset_version', array($this, 'getAssetVersion')),
        );
    }

    public function getName()
    {
        return 'asset_version';
    }
}