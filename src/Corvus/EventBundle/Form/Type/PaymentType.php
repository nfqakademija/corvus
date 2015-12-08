<?php

namespace Corvus\EventBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    private $unpaidGuests;

    public function __construct($unpaidGuests)
    {
        $this->unpaidGuests = $unpaidGuests;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('payment', 'collection', [
            'type' => 'number',
            'required' => false,
            'data' => $this->unpaidGuests,
        ])
            ->add('save', 'submit', ['label' => 'Save']);
    }

    public function getName()
    {
        return 'Payment';
    }
}
