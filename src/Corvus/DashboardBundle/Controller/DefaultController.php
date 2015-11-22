<?php

namespace Corvus\DashboardBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard/")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->find($id);

        $event_host_cnt = $user->getEventsHost()->count();
        $event_cnt = $user->getEvents()->count();

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT e
            FROM EventBundle:Event e
            JOIN e.users u
            WHERE e.host = :uid OR u.id = :uid
            ORDER BY e.endDateTime ASC
            '
        )->setParameter('uid' , $id);

        $e = $query->getResult();

        $c = array();
        $o = array();
        foreach ($e as $event)
        {
            $query = $em->createQuery(
                    'SELECT COUNT (DISTINCT o.user)
                    FROM EventBundle:Order o
                    WHERE o.event = :event
            '
            )->setParameter('event', $event->getId());

            $o[$event->getId()] = $query->getSingleScalarResult();
        }

        return array('name' => $id, 'hcount' => $event_host_cnt, 'ecount' => $event_cnt, 'events' => $e, 'ordered' => $o);
    }
}
