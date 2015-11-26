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

        $em = $this->getDoctrine()->getManager();

       /* $query = $em->createQuery(
            'SELECT e
            FROM EventBundle:Event e
            JOIN e.users u
            WHERE e.host = :uid OR u.id = :uid
            ORDER BY e.endDateTime ASC
            '
        )->setParameter('uid' , $id);

        $e = $query->getResult();*/

        $query = $em->createQuery(
            'SELECT e
            FROM EventBundle:Event e
            LEFT JOIN e.users u
            WHERE e.host = :uid OR u.id = :uid
            ORDER BY e.endDateTime ASC'
        )->setParameter('uid', $id);

        $e = $query->getResult();

        dump($e);
        //exit;

        /*$c = array();
        $o = array();
        foreach ($e as $event)
        {
            $query = $em->createQuery(
                    'SELECT COUNT (DISTINCT o.user), o.event
                    FROM EventBundle:Order o
                    WHERE o.event = :event
            '
            )->setParameter('event', $event->getId());

            $o[$event->getId()] = $query->getSingleScalarResult();
            $o[] = ['event' => $event, 'ordered' => $query->getSingleScalarResult()];
        }*/

        return array('uid' => $id, 'events' => $e);
    }
}
