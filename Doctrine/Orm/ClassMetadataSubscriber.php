<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Doctrine\Orm;

use Akeneo\Bundle\EnhancedEntityBundle\Entity\EnhancedCategory;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Pim\Bundle\CatalogBundle\Entity\Category;

class ClassMetadataSubscriber implements EventSubscriber
{
    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        // the $metadata is the whole mapping info for this class
        $metadata = $eventArgs->getClassMetadata();

        if (!$metadata instanceof ClassMetadata || $metadata->getName() != Category::class) {
            return;
        }

        $metadata->mapOneToOne([
            'targetEntity' => EnhancedCategory::CLASS,
            'fieldName'    => 'enhancedCategory',
            'cascade'      => ['persist'],
            'inversedBy'   => 'category'
        ]);
    }
}
