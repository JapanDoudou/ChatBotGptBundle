<?php

namespace JapanDoudou\ChatGptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder("japandoudou_chat_gpt");
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                    ->scalarNode('openai_key')->end()
                    ->scalarNode('is_debug')->end()
                    ->scalarNode('save_history')->end()
            ->end();

        return $treeBuilder;
    }
}
