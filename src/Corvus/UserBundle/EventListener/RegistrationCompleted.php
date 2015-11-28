<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.26
 * Time: 21:30
 */

namespace Corvus\UserBundle\EventListener;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class RegistrationCompleted implements EventSubscriberInterface
{
    private $doctrine;

    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted'
        ];
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event){
        $user = $event->getUser();
        $user_email = $user->getEmail();

        $em = $this->doctrine->getEntityManager();

        $invitations = $this->doctrine
            ->getRepository('EventBundle:EventMail')->findBy(['email' => $user_email]);

        if($invitations != null) {
            foreach($invitations as $invitation){
                $event = $invitation->getEvent();
                $event->addUser($user);
                $em->remove($invitation);
            }
        }
    }
}