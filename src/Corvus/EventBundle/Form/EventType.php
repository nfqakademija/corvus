<?php

namespace Corvus\EventBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'Title'))
            ->add('dealer_id', 'entity', array(
                'class' => 'Corvus\FoodBundle\Entity\Dealer'
            ))
            ->add('title', 'text')
            ->add('end_date_time', 'date')
            ->add('submit', 'submit');
    }
    public function getName()
    {
        return 'event';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Corvus\EventBundle\Entity\Event',
        ));
    }
}
