<?php

namespace PhpSolution\FileThumbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root('file_thumb')
            ->children()
                ->arrayNode('image')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultValue(true)->end()
                    ->end()
                ->end()
                ->arrayNode('video')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultValue(false)->end()
                        ->scalarNode('ffmpeg_binaries')->defaultValue('/usr/bin/ffmpeg')->end()
                        ->scalarNode('ffprobe_binaries')->defaultValue('/usr/bin/ffprobe')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
