<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Doctrine\Common\Saver;

use Akeneo\Bundle\EnhancedEntityBundle\Entity\EnhancedCategory;
use Akeneo\Component\StorageUtils\Saver\SaverInterface;
use Akeneo\Component\StorageUtils\Saver\SavingOptionsResolverInterface;
use Akeneo\Component\StorageUtils\StorageEvents;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EnhancedCategorySaver implements SaverInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var SavingOptionsResolverInterface */
    protected $optionsResolver;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @param ObjectManager                  $objectManager
     * @param SavingOptionsResolverInterface $optionsResolver
     * @param EventDispatcherInterface       $eventDispatcher
     */
    public function __construct(
        ObjectManager $objectManager,
        SavingOptionsResolverInterface $optionsResolver,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->objectManager   = $objectManager;
        $this->optionsResolver = $optionsResolver;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param mixed $enhancedCategory
     * @param array $options
     */
    public function save($enhancedCategory, array $options = [])
    {
        if (!$enhancedCategory instanceof EnhancedCategory) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "Pim\Component\Catalog\Model\AttributeInterface", "%s" provided.',
                    ClassUtils::getClass($enhancedCategory)
                )
            );
        }

        $this->eventDispatcher->dispatch(StorageEvents::PRE_SAVE, new GenericEvent($enhancedCategory));

        $options = $this->optionsResolver->resolveSaveOptions($options);
        $this->objectManager->persist($enhancedCategory);

        if (true === $options['flush']) {
            $this->objectManager->flush();
        }

        $this->eventDispatcher->dispatch(StorageEvents::POST_SAVE, new GenericEvent($enhancedCategory));
    }
}
