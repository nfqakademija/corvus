<?php
/**
 * Created by PhpStorm.
 * User: Lezas
 * Date: 2015.12.04
 * Time: 12:09
 */

namespace Corvus\EventBundle\EventListener;


use Corvus\EventBundle\Event\SendMailsEvent;
use Swift_Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Corvus\EventBundle\EventEvents;
use Twig_Environment;

class SendMails implements EventSubscriberInterface
{
    private $mailer;
    private $twig;

    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEvents::EVENT_CREATED => 'onEventCreated',
            EventEvents::EVENT_EDITED_ADD_USERS => 'onEventEditedAddUsers',
            EventEvents::EVENT_CANCEL => 'onEventCanceled',
            EventEvents::EVENT_SUSPEND => 'onEventSuspend',
            EventEvents::EVENT_TIMEOUT => 'onEventTimeOut',
            EventEvents::EVENT_FOOD_ORDERED => 'onEventFoodOrdered',
            EventEvents::EVENT_FOOD_DELIVERED => 'onEventFoodDelivered',
        ];
    }

    public function onEventCanceled(SendMailsEvent $sendMailsEvent)
    {
        $users = $sendMailsEvent->getEvent()->getUsers();
        $event = $sendMailsEvent->getEvent();

        if($users != null) {
            foreach ($users as $user) {
                $email = $user->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Event: ' . $event->getTitle() . ' canceled')
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/eventCancel.html.twig',
                            [
                                'name' => $user->getUsername(),
                                'event' => $event
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function onEventCreated(SendMailsEvent $sendMailsEvent)
    {
        $event = $sendMailsEvent->getEvent();
        $users = $sendMailsEvent->getUsers();
        $emails = $sendMailsEvent->getEmails();

        if($users != null)
        {
            foreach ($users as $user)
            {
                $email = $user->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Invitation to event ' . $event->getTitle())
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/inviteuser.html.twig',
                            [
                                'name' => $user->getUsername(),
                                'event' => $event
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);

            }
        }

        if($emails != null)
        {
            foreach ($emails as $email)
            {
                $email_string = $email->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Invitation to event ' . $event->getTitle())
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email_string)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/inviteguest.html.twig',
                            [
                                'email' => $email_string,
                                'event' => $event
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function onEventEditedAddUsers(SendMailsEvent $sendMailsEvent)
    {
        $event = $sendMailsEvent->getEvent();
        $users = $sendMailsEvent->getUsers();
        $emails = $sendMailsEvent->getEmails();

        if($users != null)
        {
            foreach ($users as $user)
            {
                $email = $user->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Hello Email')
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/inviteuser.html.twig',
                            [
                                'name' => $user->getUsername(),
                                'event' => $event
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }

        if($emails != null)
        {
            foreach ($emails as $email)
            {
                $email_string = $email->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Hello Email')
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email_string)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/inviteguest.html.twig',
                            [
                                'email' => $email_string,
                                'event' => $event
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function onEventFoodDelivered(SendMailsEvent $sendMailsEvent)
    {
        $users = $sendMailsEvent->getEvent()->getUsers();

        if($users != null)
        {
            foreach ($users as $user)
            {
                $email = $user->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Food delivered')
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/foodDelivered.html.twig',
                            [
                                'name' => $user->getUsername(),
                                'event' => $sendMailsEvent->getEvent()
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function onEventFoodOrdered(SendMailsEvent $sendMailsEvent)
    {
        $event = $sendMailsEvent->getEvent();
        $deliveryTime = $event->getDeliveryDateTime();
        $users = $event->getUsers();

        if($users != null)
        {
            foreach ($users as $user)
            {
                $email = $user->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Food ordered')
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/foodOrdered.html.twig',
                            [
                                'name' => $user->getUsername(),
                                'event' => $event,
                                'delivery_time' => $deliveryTime
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function onEventSuspend(SendMailsEvent $sendMailsEvent)
    {
        $event = $sendMailsEvent->getEvent();
        $users = $event->getUsers();

        if($users != null)
        {
            foreach ($users as $user)
            {
                $email = $user->getEmail();

                $message = $this->mailer->createMessage()
                    ->setSubject('Food ordered')
                    ->setFrom('corvusfood@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->twig->render(
                            '@Event/Emails/eventSuspend.html.twig',
                            [
                                'name' => $user->getUsername(),
                                'event' => $event,
                            ]
                        ),
                        'text/html'
                    );
                $this->mailer->send($message);
            }
        }
    }

    public function onEventTimeOut(SendMailsEvent $sendMailsEvent)
    {
        $event = $sendMailsEvent->getEvent();
        $host = $event->getHost();
        $email = $host->getEmail();

        $message = $this->mailer->createMessage()
            ->setSubject('Hello Email')
            ->setFrom('corvusfood@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->twig->render(
                    '@Event/Emails/timeout.html.twig',
                    [
                        'name' => $host->getUsername(),
                        'event' => $event
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}