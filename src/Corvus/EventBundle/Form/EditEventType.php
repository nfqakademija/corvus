<?php

namespace Corvus\EventBundle\Form;

use Corvus\EventBundle\Form\EventMailType;
use Corvus\UserBundle\CorvusUserBundle;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Propel\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('label' => 'Title'))
            ->add('dealer', 'entity', array(
                'class' => 'Corvus\FoodBundle\Entity\Dealer',
                'disabled' => true
            ))
            ->add('title', 'text', array(
                'disabled' => true
            ))
            ->add('end_date_time', 'datetime',array(
                'label' => 'Order ends:',
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'y-MM-dd HH:mm',
                'attr' => array('class' => 'date'))
            )->add('users', 'collection', array(
                'label' => null,
                'type' => new UserEmailType(),
                'disabled' => true
            ))
            ->add('emails', 'collection', array(
                'label' => 'Guests:',
                'type' => new EventMailType,
                'allow_add'    => true))
            ->add('submit', 'submit', array('label' => 'Save'));
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
