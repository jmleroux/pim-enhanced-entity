<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Form\Event;

use Akeneo\Bundle\EnhancedEntityBundle\Entity\EnhancedCategory;
use Akeneo\Component\StorageUtils\Saver\SaverInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

class AddEnhancedCategorySubscriber implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /** @var ObjectRepository */
    private $repository;

    /** @var SaverInterface */
    private $saver;

    public function __construct(
        FormFactoryInterface $factory,
        ObjectRepository $repository,
        SaverInterface $saver
    )
    {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->saver = $saver;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::POST_SUBMIT  => 'saveEntity',
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $category = $event->getData();
        $form = $event->getForm();

        $extra = null;

        if (null !== $category && null !== $category->getId()) {
            $extra = $this->repository->findOneBy(['category' => $category]);
        }

        if (null === $extra) {
            $extra = new EnhancedCategory();
            $extra->setCategory($category);
        }

        $form->add('enhanced', 'pim_category_enhanced', [
            'mapped' => false,
            'data'   => $extra,
        ]);
    }

    public function saveEntity(FormEvent $event)
    {
        $categoryForm = $event->getForm();
        $enhancedForm = $categoryForm->get('enhanced');

        if ($enhancedForm->isValid()) {
            $enhancedCategory = $enhancedForm->getData();
            $this->saver->save($enhancedCategory);
        }
    }
}
