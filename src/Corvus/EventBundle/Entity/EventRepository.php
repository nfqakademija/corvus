<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/28/2015
 * Time: 01:19
 */

namespace Corvus\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function getUserEventsOrderedByDate($id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT e
            FROM EventBundle:Event e
            LEFT JOIN e.users u
            WHERE (e.host = :uid OR u.id = :uid) AND e.status > 0
            ORDER BY e.status ASC, ABS(e.endDateTime - CURRENT_TIMESTAMP()) ASC'
        )->setParameter('uid', $id);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getUsersWithOrders($id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT DISTINCT (u)
            FROM EventBundle:Event e
            LEFT JOIN e.orders o
            LEFT JOIN e.users u
            WHERE e.id = :eid AND o.user = u'
        )->setParameter('eid', $id);

        return $query->getResult();
    }
}