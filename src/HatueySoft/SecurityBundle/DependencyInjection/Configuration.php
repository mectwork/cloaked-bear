<?php

namespace HatueySoft\SecurityBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('hatuey_soft_security');
        $rootNode->children()
            ->scalarNode('security_config')->defaultValue('config.yml')->end()
            ->end();
        $rootNode->children()
            ->scalarNode('command_scope')->defaultValue('app/')->end()
            ->end();

          $rootNode->children()
                      ->arrayNode('acl')
                           ->performNoDeepMerging()
                           ->addDefaultsIfNotSet()
                           ->children()
                                ->arrayNode('entities')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('class')->end()
                                            ->arrayNode('rules')
                                                ->prototype('variable')->end()
                                                ->info('The list of actions enabled in the "class"')
                                            ->end()
                                        ->end()
                                    ->end()
                                 ->end()
                           ->end()
                       ->end()
                     ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}