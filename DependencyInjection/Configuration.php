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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lit_group_gearman');

        $rootNode
            ->fixXmlConfig('server')
            ->children()
                ->arrayNode('servers')
                    ->performNoDeepMerging()
                    ->validate()
                        // If user sets "servers: ~" in the configuration then default value will not applied.
                        // Therefore we add this validation. But defaultValue() also needed to show
                        // default value in the dump of reference.
                        ->always(function ($v) { return empty($v) ? ['127.0.0.1:4703'] : $v;  })
                    ->end()
                    ->defaultValue(['127.0.0.1:4703'])
                    ->info('List of IP addresses and ports (optional) of Gearman servers.')
                    ->prototype('scalar')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }


}
