<?php

namespace PhpSolution\FileThumbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidDefinitionException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * FileThumbExtension
 */
class FileThumbExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!$config['image']['enabled']) {
            $container->removeDefinition('thumb.generator.thumb_generator.image');
        }

        if (!$config['video']['enabled']) {
            $container->removeDefinition('thumb.ffmpeg');
            $container->removeDefinition('thumb.generator.thumb_generator.video');
        } elseif (!class_exists('FFMpeg\FFMpeg')) {
            throw new InvalidDefinitionException('Undefined FFMpeg vendor library. Please run: composer require php-ffmpeg/php-ffmpeg');
        } else {
            $container->getDefinition('thumb.ffmpeg')
                ->addArgument($config['video']['ffmpeg_binaries'])
                ->addArgument($config['video']['ffprobe_binaries']);
        }

        if (!$config['image']['enabled']) {
            $container->removeDefinition('thumb.generator.thumb_generator.image');
        }

        if (!$config['video']['enabled'] && !$config['image']['enabled']) {
            $container->removeDefinition('file.event.thumb_subscriber');
        }
    }
}
