<?php

namespace Sw\Arc2Bundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('sw_arc2');

        $rootNode
            ->children()
                ->scalarNode('arc2_path')->defaultValue('./')->end()
                ->arrayNode('database')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('host')    ->defaultValue('localhost') ->end()
                        ->scalarNode('user')    ->defaultValue('root')      ->end()
                        ->scalarNode('password')->defaultValue('')          ->end()
                        ->scalarNode('database')->defaultValue('symfony')   ->end()
                    ->end()
                ->end()
                ->arrayNode('sparql_endpoint')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('store')    ->defaultValue('sandbox')   ->end()
                        ->scalarNode('timeout')  ->defaultValue('60')        ->end()
                        ->scalarNode('read_key') ->defaultValue('')          ->end()
                        ->scalarNode('write_key')->defaultValue('')          ->end()
                        ->scalarNode('limit')    ->defaultValue('')          ->end()
                        ->arrayNode('features')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('select')   ->defaultValue(true)->end()
                                ->scalarNode('construct')->defaultValue(true)->end()
                                ->scalarNode('ask')      ->defaultValue(true)->end()
                                ->scalarNode('describe') ->defaultValue(true)->end()
                                ->scalarNode('load')     ->defaultValue(true)->end()
                                ->scalarNode('insert')   ->defaultValue(true)->end()
                                ->scalarNode('delete')   ->defaultValue(true)->end()
                                ->scalarNode('dump')     ->defaultValue(true)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTree()
    {
        return $this->getConfigTreeBuilder()->buildTree(); 
    }
}
