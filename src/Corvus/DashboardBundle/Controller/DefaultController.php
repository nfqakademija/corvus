<?php

namespace Corvus\DashboardBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard/", name="dashboard")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->find($id);

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT e
            FROM EventBundle:Event e
            LEFT JOIN e.users u
            WHERE e.host = :uid OR u.id = :uid
            ORDER BY e.endDateTime ASC'
        )->setParameter('uid', $id);

        $e = $query->getResult();

        //dump($e);
        return array('uid' => $id, 'events' => $e);
    }

    /**
     * @Route("/suspend/{eventId}", name="suspend")
     */
    public function suspendAction($eventId)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getRepository('EventBundle:Event')->find($eventId);
        switch ($event->getStatus())
        {
            case 1:
                $event->setStatus(2);
                $em->flush();
                return $this->redirectToRoute('dashboard');
                break;
            case 2:
                $now = new \DateTime('now');
                $endTime = $event->getEndDateTime();
                if ($now->diff($endTime) > 0)
                {
                    $event->setStatus(1);
                    $em->flush();
                }
                return $this->redirectToRoute('dashboard');
                break;
            default:
                return $this->redirectToRoute('dashboard');

        }
    }
}
