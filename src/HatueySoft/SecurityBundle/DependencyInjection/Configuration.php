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
        $rootNode
            ->children()
                ->scalarNode('security_config')
                    ->defaultValue('%kernel.root_dir%/config/security_conf.yml')
                ->end()
            ->end();
        $rootNode
            ->children()
                ->scalarNode('command_scope')
                    ->defaultValue('%kernel.root_dir%')
                ->end()
            ->end();
        $rootNode
            ->children()
                ->scalarNode('config_file')
                    ->defaultValue('%kernel.root_dir%/config/security_acl.yml')
                ->end()
            ->end();

        $rootNode
            ->children()
                ->arrayNode('acl')
                    ->performNoDeepMerging()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('symfony_acl')
                            ->defaultTrue()
                            ->info('Enable/Disable Symfony ACL Mechanism.')
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('entities')
                            ->info('List of entities under ACL control.')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')
                                        ->info('Name to show for this entity.')
                                    ->end()
                                    ->scalarNode('class')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                        ->info('Entity path.')
                                    ->end()
                                    ->arrayNode('rules')
                                        ->prototype('scalar')->end()
                                        ->info('The list of actions enabled in the "class".
    By default contains create, view, edit, delete, list and search.
    To exclude one of the default rule, prepend "!" and then the rule.
    Ex: "!create"')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end(); // end root node

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
