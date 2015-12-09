<?php

namespace Corvus\EventBundle\Form;

use Corvus\EventBundle\Form\EventMailType;
use Corvus\EventBundle\Validator\Constraints\DateTimeNotPast;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Count;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', ['label' => 'Title'])
            ->add('dealer', 'entity', [
                'class' => 'Corvus\FoodBundle\Entity\Dealer'
            ])
            ->add('title', 'text')
            ->add('end_date_time', 'datetime', [
                'label' => 'Order end time',
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'y-MM-dd HH:mm',
                'attr' => ['class' => 'date'],
                'constraints' => new DateTimeNotPast()
                ]
            )
            ->add('emails', 'collection', [
                'constraints' => new Count([
                    'min' => 1,
                    'max' => 50,
                    'minMessage' => 'Invite at least one guest',
                    'maxMessage' => 'Can not invite more than 50 guests'
                ]),
                'label' => 'Email invitations',
                'type' => new EventMailType,
                'allow_add'    => true])
            ->add('submit', 'submit', ['label' => 'Create']);
    }
    public function getName()
    {
        return 'event';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Corvus\EventBundle\Entity\Event'
        ]);
    }
}
