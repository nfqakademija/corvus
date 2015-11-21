<?php

namespace Corvus\EventBundle\Controller;

use Corvus\EventBundle\Entity\Order;
use Corvus\FoodBundle\Entity\Dish;
use Corvus\EventBundle\Form\Type\OrderType;
use Corvus\MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/event/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'Event');
    }

    /**
     * @Route("/event/{id}/pick", name="select_food")
     * @Template()
     */
    public function pickAction($id)
    {

        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        /* If not logged in, user will be redirected*/
        if ($isFullyAuthenticated) {
            $event = $this->getDoctrine()
                ->getRepository('EventBundle:Event')
                ->find($id);

            /* Throw exception if event with that id doesnt exists*/
            if (!$event) {
                throw $this->createNotFoundException(
                    'No event found for id '.$id
                );
            } else {

                /*In future need to add security level, that only users which participates in event can reach this page*/

                $dealer_id =  $event->getDealer();
                $event_name = $event->getTitle();

                $dealer = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dealer')->find($dealer_id);

                $dealer_name = $dealer->getName();

                $dishes = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dish')->findBy(array('dealer' => $dealer_id));

                $orders = $this->getDoctrine()
                    ->getRepository('EventBundle:Order')->findBy(array('id' => '1'));

                $form = $this->createFormBuilder()->add('orders', 'collection', array(
                    'type'         => new OrderType($orders),
                    'allow_add'    => true,
                    'allow_delete' => true,
                ))->getForm();


                return $this->render('EventBundle:Default:index.html.twig', array(
                    'event_name' => $event_name,
                    'dealer' =>  $dealer_name,
                    'dishes' => $dishes,
                    'orders' => $orders,
                    'form' => $form->createView(),
                ));
            }
        } else {
            return $this->redirectToRoute('corvus_main');
        }
    }

    /**
     * @Route("/event/{id}/order",name="order_food")
     *
     */
    public function orderAction($id)
    {
        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        /* If not logged in, user will be redirected*/
        if ($isFullyAuthenticated) {
            $event = $this->getDoctrine()
                ->getRepository('EventBundle:Event')
                ->find($id);

            /* Throw exception if event with that id doesnt exists*/
            if (!$event) {
                throw $this->createNotFoundException(
                    'No event found for id '.$id
                );
            } else {
                $event_status =$event->getStatus();
                /* Status event must be 2, that means that event is suspend, time for order is out, now host must call
                for dealer and order food for real*/
                if($event_status != 2){
                    throw $this->createNotFoundException(
                        'Event status is incorect '.$event_status
                    );
                } else {

                    $orders = $this->getDoctrine()
                        ->getRepository('EventBundle:Order')->findAll();


                    $dealer_id =  $event->getDealer();


                    $dealer = $this->getDoctrine()
                        ->getRepository('FoodBundle:Dealer')->find($dealer_id);

                    $dealer_name = $dealer->getName();

                    $dishes = $this->getDoctrine()
                        ->getRepository('FoodBundle:Dish')->findBy(array('dealer' => $dealer_id));


                    return $this->render('EventBundle:Default:order.html.twig', array(
                        'event' => $event,
                        'dealer' =>  $dealer_name,
                        'dishes' => $dishes,
                        'orders' => $orders,
                    ));
                }
            }

        } else {
            return $this->redirectToRoute('corvus_main');
        }
    }
}
