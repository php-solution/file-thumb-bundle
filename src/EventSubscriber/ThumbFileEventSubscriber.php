<?php

namespace PhpSolution\FileThumbBundle\EventSubscriber;

use PhpSolution\FileStorageBundle\Event\StorageInfoEvent;
use PhpSolution\FileStorageBundle\Event\UploadFileEvent;
use PhpSolution\FileStorageBundle\Lib\StorageProvider;
use PhpSolution\FileThumbBundle\Lib\File\ThumbStorageInfo;
use PhpSolution\FileThumbBundle\Lib\Generator\GeneratorProvider;
use PhpSolution\FileThumbBundle\Lib\ThumbedInterface;
use PhpSolution\FileStorageBundle\Event\FileEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * ThumbFileEventSubscriber
 */
class ThumbFileEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var StorageProvider
     */
    private $storageProvider;

    /**
     * @var GeneratorProvider
     */
    private $generatorProvider;

    /**
     * @param StorageProvider   $storageProvider
     * @param GeneratorProvider $generatorProvider
     */
    public function __construct(StorageProvider $storageProvider, GeneratorProvider $generatorProvider)
    {
        $this->storageProvider = $storageProvider;
        $this->generatorProvider = $generatorProvider;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FileEvents::POST_UPLOAD => ['postUpload', -1],
            FileEvents::ON_REMOVE => ['onRemove', -1],
        ];
    }

    /**
     * @param UploadFileEvent $event
     */
    public function postUpload(UploadFileEvent $event)
    {
        if (!($storageInfo = $event->getStorageInfo()) instanceof ThumbedInterface) {
            return;
        }

        $storage = $this->storageProvider->getStorageByName($storageInfo->getStorage());
        $thumbGenerator = $this->generatorProvider->getGenerator($storageInfo->getFile()->getMimeType());
        $thumbGenerator->generate($storageInfo, $storage);
    }

    /**
     * @param StorageInfoEvent $event
     */
    public function onRemove(StorageInfoEvent $event)
    {
        $storageInfo = $event->getStorageInfo();
        if (!$storageInfo instanceof ThumbedInterface) {
            return;
        }
        $storage = $this->storageProvider->getStorageByName($storageInfo->getStorage());
        foreach ($storageInfo->getThumbsDimensions() as $key => $dimensions) {
            $storage->remove(new ThumbStorageInfo($storageInfo, $key));
        }
    }
} 