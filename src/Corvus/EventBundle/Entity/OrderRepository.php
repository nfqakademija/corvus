<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.28
 * Time: 13:53
 */

namespace Corvus\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function getPeopleCountWhoOrdered(Event $event)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(DISTINCT o.user)
                            FROM EventBundle:Order o
                            WHERE o.event = :event'
        )->setParameter('event', $event->getId());

        $people_count = $query->getSingleScalarResult();

        return $people_count;
    }

    public function getGroupedOrders(Event $event)
    {
        $query = $this->getEntityManager()->createQuery(
        'SELECT o orders, SUM(o.quantity) quantity_sum, SUM(o.pricePerUnit*o.quantity) price_sum
        FROM EventBundle:Order o
        WHERE o.event = :event
        GROUP BY o.dish'
        )->setParameter('event', $event->getId());

        return $orders = $query->getResult();
    }
}
