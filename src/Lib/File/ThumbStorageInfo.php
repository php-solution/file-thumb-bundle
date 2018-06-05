<?php

namespace PhpSolution\FileThumbBundle\Lib\File;

use PhpSolution\FileStorageBundle\Lib\File\StorageInfoInterface;
use PhpSolution\FileThumbBundle\Lib\ThumbedInterface;

/**
 * ThumbStorageInfo
 */
class ThumbStorageInfo implements StorageInfoInterface
{
    /**
     * @var StorageInfoInterface;
     */
    private $original;
    /**
     * @var int|string
     */
    private $key;

    /**
     * @param StorageInfoInterface $original
     * @param int|string           $key
     */
    public function __construct(StorageInfoInterface $original, $key)
    {
        $this->original = $original;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getStorage(): string
    {
        return $this->original->getStorage();
    }

    /**
     * @param string $storage
     *
     * @return self
     */
    public function setStorage(string $storage)
    {
        throw new \RuntimeException('This class extend storage from original file');
    }

    /**
     * @return string
     */
    public function getStoragePath(): string
    {
        $originalStoragePath = $this->original->getStoragePath();
        $pathInfo = pathinfo($originalStoragePath);

        return $pathInfo['filename']
            . ThumbedInterface::THUMB_SUFFIX
            . $this->key
            . (array_key_exists('extension', $pathInfo) ? '.' . $pathInfo['extension'] : '');
    }

    /**
     * @return string
     */
    public function getStorageAlias(): string
    {
        return $this->original->getStorageAlias();
    }

    /**
     * @return string
     */
    public function getStorageBucket()
    {
        return $this->original->getStorageBucket();
    }
}