<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.29
 * Time: 17:38
 */

namespace Corvus\EventBundle;


final class EventEvents
{
    /*
     * The event.created event is thrown every time, then new event is created.
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\FilterEventResponseEvent
     *
     *@var string
     */
    const EVENT_CREATED = 'event.created';

    const EVENT_TIMEOUT = 'event.timeout';

    const EVENT_SUSPEND = 'event.suspend';

    const EVENT_FOOD_ORDERED = 'event.food.ordered';

    const EVENT_FOOD_DELIVERED = 'event.food.delivered';
}