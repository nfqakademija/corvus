<?php

namespace Corvus\EventBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemindDebtsType extends AbstractType
{
    private $url;

    public function __construct( $url = null)
    {

        $this->url = $url;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('save', 'submit', [
            'label' => 'Remind To pay debts',
            ]
        )->setAction($this->url['url']);

    }
    public function getName()
    {
        return 'RemindDebts';
    }
}