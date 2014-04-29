<?php

namespace PHPOrchestra\ThemeBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('php_orchestra_theme');
        
        $rootNode
            ->children()
                ->arrayNode('themes')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('javascripts')
                                ->prototype('scalar')->end()
                                ->end()
                            ->arrayNode('stylesheets')
                                ->prototype('scalar')->end()
                                ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        
        return $treeBuilder;
    }
}
