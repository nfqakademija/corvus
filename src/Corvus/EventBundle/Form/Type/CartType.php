<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.22
 * Time: 16:15
 */

namespace Corvus\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('orders', 'collection', array(
            'type' => new OrderType(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            ))
            ->add('save', 'submit');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Corvus\EventBundle\Entity\Cart',
        ));
    }

    public function getName()
    {
        return 'cart';
    }
}