<?php

namespace Corvus\EventBundle\Form\Type;

use Corvus\EventBundle\Validator\Constraints\DateTimeNotPast;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissingDishCheckType extends AbstractType
{
    private $dish_ids;

    public function __construct($dish_ids)
    {
        $this->dish_ids = $dish_ids;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dish_id', 'collection', [
            'type' => 'checkbox',
            'required' => false,
            'data' => $this->dish_ids,
            ])
            ->add('dueDate', 'datetime', [
                'widget' => 'single_text',
                'format' => 'y-MM-dd HH:mm',
                'model_timezone' => 'UTC',
                'view_timezone' => 'Europe/Vilnius',
                'attr' => ['class' => 'date'],
                'constraints' => [
                    new DateTimeNotPast()
                ]
            ])
            ->add('save', 'submit', ['label' => 'Save']);
    }
    public function getName()
    {
        return 'MissingDishCheck';
    }
}
