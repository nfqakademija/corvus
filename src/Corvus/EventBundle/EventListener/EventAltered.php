<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.12.04
 * Time: 12:22
 */

namespace Corvus\EventBundle\EventListener;


use Corvus\EventBundle\EventEvents;
use Corvus\EventBundle\Event\EventStatusChangeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventAltered implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EventEvents::EVENT_CREATED => 'onEventCreated',
            EventEvents::EVENT_TIMEOUT => 'onEventSuspend',
            EventEvents::EVENT_SUSPEND => 'onEventSuspend',
            EventEvents::EVENT_CANCEL => 'onEventCancel',
            EventEvents::EVENT_FOOD_ORDERED => 'onEventFoodOrdered',
            EventEvents::EVENT_FOOD_DELIVERED => 'onEventFoodDelivered',
            EventEvents::EVENT_EDITED_TIME_EXTENDED => 'onEventTimeExtended',
            EventEvents::EVENT_NO_DEBTS => 'onEventNoDebts',
        ];
    }

    public function onEventCancel(EventStatusChangeEvent $event)
    {
        $Corvus_event = $event->getEvent();
        $Corvus_event->setIsDeleted(true);
        $Corvus_event->setStatus(0);
        $orders = $event->getEvent()->getOrders();

        if($orders != null) {
            foreach ($orders as $order) {
                $order->setIsRemoved(true);
            }
        }

    }

    public function onEventCreated(EventStatusChangeEvent $event)
    {
        $event->getEvent()->setStatus(1);
    }

    public function onEventFoodDelivered(EventStatusChangeEvent $event)
    {
        if ($event->getEvent()->getDebtLeft() != 0) {
            $event->getEvent()->setStatus(4);
        } else {
            $event->getEvent()->setStatus(5);
        }
    }

    public function onEventFoodOrdered(EventStatusChangeEvent $event)
    {
        $event->getEvent()->setStatus(3);
    }

    public function onEventNoDebts(EventStatusChangeEvent $event)
    {
        $event->getEvent()->setStatus(5);
    }

    public function onEventSuspend(EventStatusChangeEvent $event)
    {
        $event->getEvent()->setStatus(2);
    }

    public function onEventTimeExtended(EventStatusChangeEvent $event)
    {
        $event->getEvent()->setStatus(1);
    }
}