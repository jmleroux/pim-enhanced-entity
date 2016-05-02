<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Event;

use Akeneo\Bundle\EnhancedEntityBundle\Entity\EnhancedCategory;
use Akeneo\Component\StorageUtils\Saver\SaverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class CategoryEventSubscriber implements EventSubscriberInterface
{
    /** @var ContainerInterface */
    private $serviceLocator;

    public function __construct(ContainerInterface $container)
    {
        $this->serviceLocator = $container;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            EnhancedEntityEvents::POST_EDIT => 'postEditCategory',
        ];
    }

    /**
     * @param GenericEvent $event
     */
    public function postEditCategory(GenericEvent $event)
    {
        $enhancedCategory = $event->getSubject();

        if (!$enhancedCategory instanceof EnhancedCategory) {
            return;
        }
        
        $this->getSaver()->save($enhancedCategory);
    }

    /**
     * @return EntityRepository
     */
    final protected function getRepository()
    {
        return $this->serviceLocator->get('pim_enhanced_entity.repository.enhanced_category');
    }

    /**
     * @return SaverInterface
     */
    final protected function getSaver()
    {
        return $this->serviceLocator->get('pim_enhanced_entity.saver.enhanced_category');
    }
}
