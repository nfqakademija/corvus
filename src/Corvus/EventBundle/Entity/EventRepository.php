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
            WHERE e.host = :uid OR u.id = :uid
            ORDER BY e.endDateTime ASC'
        )->setParameter('uid', $id);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getOrderedUsers($id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT u
            FROM CorvusMainBundle:User u
            LEFT JOIN u.events e
            LEFT JOIN u.orders o
            WHERE e.id = :eid'
        )->setParameters(['eid' => $id]);

        return $query->getScalarResult();
    }
}