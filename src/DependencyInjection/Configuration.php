<?php

namespace VRia\Bundle\EnhancedFileBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('v_ria_enhanced_file');

        $rootNode
            ->children()
                ->enumNode('theme')
                    ->defaultValue('div')
                    ->values(array('div', 'smart_admin'))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
