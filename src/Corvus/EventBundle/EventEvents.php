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
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     *@var string
     */
    const EVENT_CREATED = 'event.created';

    /*The event.edited.extended.time is thrown, when time is
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     *@var string
     */
    const EVENT_EDITED_TIME_EXTENDED = 'event.edited.extended.time';

    /*
     *The event.edited.add.users is thrown, when event is edited and new users are added.
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventUsersChangeEvent
     *
     *@var string
     */
    const EVENT_EDITED_ADD_USERS = 'event.edited.add.users';

    /*
     *The event.timeout event is thrown every time, then event time reaches its limit
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     *@var string
     */
    const EVENT_TIMEOUT = 'event.timeout';

    /*
     *The event.suspend is thrown when event host press Suspend button
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     *@var string
     */
    const EVENT_SUSPEND = 'event.suspend';

    /*
     *The event.cancel is thrown when event host press Cacnel Event button
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     *@var string
     */
    const EVENT_CANCEL = 'event.cancel';

    /*
     *The event.food.ordered is thrown when host orders food
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     * siusti visiems
     */
    const EVENT_FOOD_ORDERED = 'event.food.ordered';

    /*
     *The event listener receives an
     *Corvus\EventBundle\Event\SendMailsEvent
     *
     *@var string
     */
    const EVENT_FOOD_DELIVERED = 'event.food.delivered';

    /*
     * The event.no.debts is thrown, when nobody has any debts for event host
     * It changes event status to 5
     *
     *The event listener receives an
     *Corvus\EventBundle\Event\EventStatusChangeEvent
     *
     *@var string
     */
    const EVENT_NO_DEBTS= 'event.no.debts';
}
