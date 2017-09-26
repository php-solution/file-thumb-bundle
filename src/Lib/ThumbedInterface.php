<?php

namespace PhpSolution\FileThumbBundle\Lib;

/**
 * ThumbedInterface
 */
interface ThumbedInterface
{
    const THUMB_SUFFIX = '_thumb_';

    /**
     * @return array
     */
    public function getThumbsDimensions(): array;
} 