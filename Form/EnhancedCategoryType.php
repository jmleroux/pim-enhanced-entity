<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Form;

use Akeneo\Bundle\EnhancedEntityBundle\Entity\EnhancedCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EnhancedCategoryType extends AbstractType
{
    public function getName()
    {
        return 'pim_category_enhanced';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', 'text', [
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 3, 'max' => 100]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'      => EnhancedCategory::class,
                'auto_initialize' => false,
            ]
        );
    }
}
