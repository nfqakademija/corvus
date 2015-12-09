<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.12.09
 * Time: 12:02
 */

namespace Corvus\EventBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfirmCheckboxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('confirm', 'checkbox', [
                'label'     => 'Confirm',
                'required'  => false,
                'data'      => false,
            ])
            ->add('save', 'submit', ['label' => 'Confirm']);
    }

    public function getName()
    {
        return 'ConfirmCheckBox';
    }

}