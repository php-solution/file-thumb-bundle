<?php

namespace PhpSolution\FileThumbBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ThumbGeneratorsCompilerPass
 */
class ThumbGeneratorsCompilerPass implements CompilerPassInterface
{
    const GENERATOR_TAG = 'thumb.generator';

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('file_thumb.lib.generator.generator_provider')) {
            return;
        }

        $providerDefinition = $container->getDefinition('file_thumb.lib.generator.generator_provider');
        $generators = $container->findTaggedServiceIds(self::GENERATOR_TAG);
        if (count($generators) < 0) {
            return;
        }
        foreach ($generators as $generator => $params) {
            $providerDefinition->addMethodCall(
                'addGenerator',
                [
                    new Reference($generator),
                    $params[0]['alias']
                ]
            );
        }
    }
}