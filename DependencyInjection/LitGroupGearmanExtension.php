<?php

/**
 * This file is part of the LitGroup JobQueue package.
 *
 * @copyright Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\GearmanBundle\DependencyInjection;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class LitGroupGearmanExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('gearman.xml');

        $container
            ->getDefinition('litgroup_gearman.client')
            ->addMethodCall('addServers', [$config['servers']])
        ;
        $container
            ->getDefinition('litgroup_gearman.worker')
            ->addMethodCall('addServers', [$config['servers']])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return 'http://litgroup.ru/schema/dic/gearman';
    }
}
