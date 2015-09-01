<?php

namespace HatueySoft\SequenceBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('hatuey_soft_sequence');

        $rootNode
            ->children()
                ->variableNode('sequences')
                    ->defaultValue(array())
                    ->info('define las entidades que usarán las secuencias definidas')
                    ->example(' "entidad_seq:" Valor\NombreBundle\Entity\Entidad')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
