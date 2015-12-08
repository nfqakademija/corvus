<?php

namespace Corvus\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dish_id', 'number', ['mapped' => false]);
        $builder->add('quantity', 'number');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Corvus\EventBundle\Entity\Order',
        ]);
    }

    public function getName()
    {
        return 'order';
    }
}