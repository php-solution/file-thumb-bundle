<?php

namespace PhpSolution\FileThumbBundle;

use PhpSolution\FileThumbBundle\DependencyInjection\Compiler\ThumbGeneratorsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * FileThumbBundle
 */
class FileThumbBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ThumbGeneratorsCompilerPass());
    }
}
