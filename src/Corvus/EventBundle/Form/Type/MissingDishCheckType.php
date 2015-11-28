<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.28
 * Time: 11:47
 */

namespace Corvus\EventBundle\Form\Type;

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
            ->add('dueDate', 'datetime',[
                'data' => new \DateTime(),
            ])
            ->add('save', 'submit', ['label' => 'Save']);
    }
    public function getName()
    {
        return 'MissingDishCheck';
    }
}