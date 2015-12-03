<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.30
 * Time: 23:54
 */

namespace Corvus\EventBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class EventUsersChangeEvent extends Event
{
    protected $event;
    protected $users;

    public function __construct(\Corvus\EventBundle\Entity\Event $event, $users)
    {
        $this->event = $event;
        $this->users = $users;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getUsers()
    {
        return $this->users;
    }
}