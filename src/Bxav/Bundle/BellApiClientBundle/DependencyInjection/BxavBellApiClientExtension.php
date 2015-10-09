<?php

namespace Bxav\Bundle\BellApiClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BxavBellApiClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        if (isset($config['api']['url'])) {
            $container->setParameter('bxav_bell_api_client.api_url.param', $config['api']['url']);
        }
        if (isset($config['api']['user_id'])) {
            $container->setParameter('bxav_bell_api_client.user_id.param', $config['api']['user_id']);
        }
        if (isset($config['api']['key'])) {
            $container->setParameter('bxav_bell_api_client.api_key.param', $config['api']['key']);
        }
    }
}
