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
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     */
    const EVENT_CREATED = 'event.created';

    /*
     * The event.created event is thrown every time, then new event is created.
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventUsersChangeEvent
     *
     *@var string
     */
    const EVENT_EDITED_TIME_EXTENDED = 'event.edited.extended.time';

    /*
     * The event.created event is thrown every time, then new event is created.
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventUsersChangeEvent
     *
     *@var string
     */
    const EVENT_EDITED_ADD_USERS = 'event.edited.add.users';

    /*
     * the event.timeout event is thrown every time, then event time reaches its limit
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     * siusti email tik hostui
     */
    const EVENT_TIMEOUT = 'event.timeout';

    /*
     * the event.timeout
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     * siusti email visiems
     */
    const EVENT_SUSPEND = 'event.suspend';

    /*
     * the event.timeout event is thrown every time, then event time reaches its limit
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     */
    const EVENT_CANCEL = 'event.cancel';

    /*
     * the event.timeout event is thrown every time, then event time reaches its limit
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventUsersChangeEvent
     *
     *@var string
     * siusti visiems
     */
    const EVENT_FOOD_ORDERED = 'event.food.ordered';

    /*
     * the event.timeout event is thrown every time, then event time reaches its limit
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     * siusti visiems
     */
    const EVENT_FOOD_DELIVERED = 'event.food.delivered';

    /*
     * the event.timeout event is thrown every time, then event time reaches its limit
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     * siusti visiems
     */
    const EVENT_NO_DEBTS= 'event.no.debts';
}