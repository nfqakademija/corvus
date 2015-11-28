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

        $e = $this->getDoctrine()->getRepository('EventBundle:Event')->getUserEventsOrderedByDate($id);

        return ['user' => $user, 'events' => $e];
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
                return $this->redirectToRoute('order_food', ['id' => $eventId]);
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
