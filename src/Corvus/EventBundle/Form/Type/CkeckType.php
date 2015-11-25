<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.24
 * Time: 18:54
 */


namespace Corvus\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('dish_id', 'collection', array(
            'type' => 'number',
            ))
            ->add('dueDate', 'datetime', array('data' => new \DateTime()))
            ->add('save', 'submit', array('label' => 'Save'));
    }

    public function getName()
    {
        return 'check';
    }
}