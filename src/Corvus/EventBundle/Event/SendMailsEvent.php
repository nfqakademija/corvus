<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.12.04
 * Time: 12:01
 */

namespace Corvus\EventBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class SendMailsEvent extends EventStatusChangeEvent
{
    protected $event;
    protected $users;
    private $emails;

    /* Send mails event have corvus_event, users who need to send emails, and plain emails. That is because
    when creating event and adding emails, some emails doesn't exist on system, so cant create users. Need to
    send special emails to invite and register to the system. */
    public function __construct(\Corvus\EventBundle\Entity\Event $event, $users = null, $emails = null)
    {
        parent::__construct($event);
        $this->event = $event;
        $this->users = $users;
        $this->emails = $emails;
    }
    public function getEvent()
    {
        return $this->event;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getEmails()
    {
        return $this->emails;
    }
}