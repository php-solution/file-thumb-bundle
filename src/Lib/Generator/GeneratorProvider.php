<?php

namespace PhpSolution\FileThumbBundle\Lib\Generator;

use PhpSolution\FileStorageBundle\Lib\MimeTypeAnalyser;

/**
 * Generator
 */
class GeneratorProvider
{
    /**
     * @var MimeTypeAnalyser
     */
    private $mimeTypeAnalyzer;
    /**
     * @var GeneratorInterface[]
     */
    private $generators = [];

    /**
     * @param MimeTypeAnalyser $mimeTypeAnalyser
     */
    public function __construct(MimeTypeAnalyser $mimeTypeAnalyser)
    {
        $this->mimeTypeAnalyzer = $mimeTypeAnalyser;
    }

    /**
     * @param GeneratorInterface $generator
     * @param string             $alias
     *
     * @return self
     */
    public function addGenerator(GeneratorInterface $generator, $alias)
    {
        $this->generators[$alias] =  $generator;

        return $this;
    }

    /**
     * @param string $mimeType
     *
     * @return GeneratorInterface
     * @throws \RuntimeException
     */
    public function getGenerator(string $mimeType): GeneratorInterface
    {
        $alias = $this->mimeTypeAnalyzer->getType($mimeType);
        if (!array_key_exists($alias, $this->generators)) {
            throw new \RuntimeException(sprintf('Thumb generator for MIME type "%s" was not found', $mimeType));
        }

        return $this->generators[$alias];
    }
}