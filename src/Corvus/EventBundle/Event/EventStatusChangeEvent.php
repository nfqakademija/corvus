<?php
/**
 * Created by PhpStorm.
 * User: Lezas
 * Date: 2015.11.30
 * Time: 23:52
 */

namespace Corvus\EventBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EventStatusChangeEvent extends Event
{
    private $event;

    public function __construct(\Corvus\EventBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }
}
