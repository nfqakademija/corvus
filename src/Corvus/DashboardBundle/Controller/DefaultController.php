<?php

namespace Corvus\DashboardBundle\Controller;

use Corvus\EventBundle\Event\SendMailsEvent;
use Corvus\EventBundle\EventEvents;
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
        $isFullyAuthenticated = $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isFullyAuthenticated)
        {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $event = $this->getDoctrine()->getRepository('EventBundle:Event')->getUserEventsOrderedByDate($user->getId());

            return [
                'user' => $user,
                'events' => $event
            ];
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
                    $dispatcher = $this->get('event_dispatcher');
                    $dispatcher->dispatch(EventEvents::EVENT_SUSPEND, new SendMailsEvent($event));
                    $em->persist($event);
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

    /**
     * @Route("/orderArrived/{id}", name="order_arrived")
     * @param integer
     */
    public function orderArrivedAction($id)
    {
        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        /* If not logged in, user will be redirected*/
        if (!$isFullyAuthenticated)
        {
            throw $this->createNotFoundException(
                'Not found'
            );
        }else
        {
            $event = $this->getDoctrine()
                ->getRepository('EventBundle:Event')
                ->find($id);

            /* Throw exception if event with that id doesn't exists*/
            if (!$event)
            {
                throw $this->createNotFoundException(
                    'No event found for id ' . $id
                );
            } else
            {
                $user = $this->container->get('security.context')->getToken()->getUser();
                if ($event->getHost() != $user)
                {
                    throw $this->createNotFoundException(
                        'No event found for id ' . $id
                    );
                } else
                {
                    $em = $this->getDoctrine()->getManager();
                    $dispatcher = $this->get('event_dispatcher');
                    $dispatcher->dispatch(EventEvents::EVENT_FOOD_DELIVERED, new SendMailsEvent($event));
                    $em->persist($event);
                    $em->flush();
                    return $this->redirectToRoute('dashboard');
                }
            }
        }
    }
}
