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
        $builder->add('title', 'text', ['label' => 'Title'])
            ->add('dealer', 'entity', [
                'class' => 'Corvus\FoodBundle\Entity\Dealer',
                'disabled' => true
            ])
            ->add('title', 'text', [
                'disabled' => true
            ])
            ->add('end_date_time', 'datetime', [
                'label' => 'Order end time',
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'y-MM-dd HH:mm',
                'attr' => ['class' => 'date']]
            )->add('users', 'collection', [
                'label' => null,
                'type' => new UserEmailType(),
                'disabled' => true
            ])
            ->add('emails', 'collection', [
                'label' => 'Email invitations',
                'type' => new EventMailType,
                'allow_add'    => true])
            ->add('submit', 'submit', ['label' => 'Save']);
    }

    public function getName()
    {
        return 'event';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Corvus\EventBundle\Entity\Event',
        ]);
    }
}
