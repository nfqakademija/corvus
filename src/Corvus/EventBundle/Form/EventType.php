<?php

namespace Corvus\EventBundle\Form;

use Corvus\EventBundle\Form\EventMailType;
use Corvus\EventBundle\Validator\Constraints\DateTimeNotPast;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', ['label' => 'Title'])
            ->add('dealer', 'entity', [
                'class' => 'Corvus\FoodBundle\Entity\Dealer'
            ])
            ->add('title', 'text')
            ->add('end_date_time', 'datetime',[
                'label' => 'Order ends:',
                'input' => 'datetime',
                'widget' => 'single_text',
                'format' => 'y-MM-dd HH:mm',
                'attr' => ['class' => 'date'],
                    'constraints' => [
                        new DateTimeNotPast()
                    ]
                ]
            )
            ->add('emails', 'collection', [
                'label' => 'Guests:',
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
