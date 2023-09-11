<?php

namespace JapanDoudou\ChatGptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder("japandoudou_backup_bundle");
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('connections')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('uploaded_files_paths')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('file_infos')
                    ->children()
                        ->scalarNode('file_systeme_path')->end()
                        ->scalarNode('instance_name')->end()
                        ->scalarNode('life_time')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
