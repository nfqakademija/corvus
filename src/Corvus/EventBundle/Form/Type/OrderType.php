<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.21
 * Time: 16:10
 */

namespace Corvus\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dish_id', 'number');
        $builder->add('quantity', 'number');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Corvus\EventBundle\Entity\Order',
        ));
    }

    public function getName()
    {
        return 'Order';
    }
}