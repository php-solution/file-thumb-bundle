<?php

namespace PhpSolution\FileThumbBundle\Lib\Generator;

use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Imagine\Gd\Imagine;
use PhpSolution\FileStorageBundle\Lib\File\StorageInfoInterface;
use PhpSolution\FileStorageBundle\Lib\Storage\StorageInterface;
use PhpSolution\FileThumbBundle\Lib\File\ThumbStorageInfo;
use PhpSolution\FileThumbBundle\Lib\ThumbedInterface;

/**
 * ImageGenerator
 */
class ImageGenerator implements GeneratorInterface
{
    /**
     * @param StorageInfoInterface $storageInfo
     * @param StorageInterface     $storage
     */
    public function generate(StorageInfoInterface $storageInfo, StorageInterface $storage): void
    {
        if (!$storageInfo instanceof ThumbedInterface) {
            throw new \RuntimeException(sprintf('"%s%", is not implement ThumbedInterface', get_class($storageInfo)));
        }
        $imagine = new Imagine();
        $image = $imagine->load($storage->read($storageInfo));

        foreach ($storageInfo->getThumbsDimensions() as $key => $thumbDimensions) {
            $box = new Box($thumbDimensions['w'], $thumbDimensions['h']);
            $thumb = $image->thumbnail($box, ImageInterface::THUMBNAIL_INSET);
            $storage->write($thumb, new ThumbStorageInfo($storageInfo, $key));
        }
    }
}