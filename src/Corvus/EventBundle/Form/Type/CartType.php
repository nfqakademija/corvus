<?php

namespace Corvus\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('orders', 'collection', [
            'type' => new OrderType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'label' => false,
            ])
            ->add('save', 'submit');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Corvus\EventBundle\Entity\Cart',
        ]);
    }

    public function getName()
    {
        return 'cart';
    }
}