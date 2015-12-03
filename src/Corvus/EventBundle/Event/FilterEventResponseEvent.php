<?php
/**
 * Created by PhpStorm.
 * User: Lezas
 * Date: 2015.11.29
 * Time: 17:53
 */

namespace Corvus\EventBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class FilterEventResponseEvent extends Event
{
    protected $event;

    public function __construct(\Corvus\EventBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }
}