<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.12.01
 * Time: 14:20
 */

namespace Corvus\EventBundle\EventListener;


use Corvus\EventBundle\Event\EventUsersChangeEvent;
use Corvus\EventBundle\Event\EventEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventCreated implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEvents::EVENT_CREATED => 'onEventCreated'
        ];
    }

    public function onEventCreated(EventUsersChangeEvent $event)
    {
        /*Need to ckeck emails, if that email is not in DB, add to event_email and sen to it. Otherwise do stock
        */

        echo "pass";

        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('corvusfood@gmail.com')
            ->setTo('pkupetis6@gmail.com')
            ->setBody(
                'Hello my friend.'
            )

        ;
        $this->mailer->send($message);

    }
}