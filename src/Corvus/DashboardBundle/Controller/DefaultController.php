<?php

namespace Corvus\DashboardBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard/", name="dashboard")
     * @Template()
     */
    public function indexAction()
    {
        $isFullyAuthenticated = $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isFullyAuthenticated)
        {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $event = $this->getDoctrine()->getRepository('EventBundle:Event')->getUserEventsOrderedByDate($user->getId());

            return ['user' => $user, 'events' => $event];
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/suspend/{eventId}", name="suspend")
     * @param integer
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
                if ($now < $endTime)
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
