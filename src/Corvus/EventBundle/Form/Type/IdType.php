<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.22
 * Time: 17:48
 */
namespace Corvus\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'number' => 0,
        ));
    }

    public function getParent()
    {
        return 'number';
    }

    public function getName()
    {
        return 'Id';
    }
}