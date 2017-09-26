<?php

namespace PhpSolution\FileThumbBundle\Lib\Generator;

use PhpSolution\FileStorageBundle\Lib\File\StorageInfoInterface;
use PhpSolution\FileStorageBundle\Lib\Storage\StorageInterface;

/**
 * GeneratorInterface
 */
interface GeneratorInterface
{
    /**
     * @param StorageInfoInterface $storageInfo
     * @param StorageInterface     $storage
     */
    public function generate(StorageInfoInterface $storageInfo, StorageInterface $storage): void;
} 