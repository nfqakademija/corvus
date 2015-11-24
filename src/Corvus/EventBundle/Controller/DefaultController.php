<?php

namespace Corvus\EventBundle\Controller;

use Corvus\EventBundle\Entity\Cart;
use Corvus\EventBundle\Entity\Order;
use Corvus\EventBundle\Form\Type\CartType;
use Corvus\FoodBundle\Entity\Dish;
use Corvus\EventBundle\Form\Type\OrderType;
use Corvus\MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/event/{id}")
     * @Template()
     */
    public function indexAction($id)
    {
        return array('name' => $id);
    }

    /**
     * @Route("/event/{id}/pick", name="select_food")
     * @Template()
     */
    public function pickAction($id, Request $request)
    {

        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        /* If not logged in, user will be redirected*/
        if ($isFullyAuthenticated) {
            $event = $this->getDoctrine()
                ->getRepository('EventBundle:Event')
                ->find($id);

            /* Throw exception if event with that id doesn't exists*/
            if (!$event) {
                throw $this->createNotFoundException(
                    'No event found for id '.$id
                );
            } else {
                $user = $this->container->get('security.context')->getToken()->getUser();
                /*!IMPORTANT!*/
                /*In future need to add security level, that only users which participates in event can reach this page*/
                /*if(!$event->getUsers()->contains($user))
                {
                    throw $this->createNotFoundException(
                        'You are not in this event'.$id
                    );
                }*/

                $em = $this->getDoctrine()->getManager();

                $dealer_id = $event->getDealer();
                $event_name = $event->getTitle();

                $dealer = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dealer')->find($dealer_id);

                $dealer_name = $dealer->getName();

                $dishes = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dish')->findBy(array('dealer' => $dealer_id));


                $OriginalOrders = $this->getDoctrine()
                    ->getRepository('EventBundle:Order')->findBy(array('event' => $event, 'user' => $user));


                $cart = new Cart();

                if ($OriginalOrders != null) {
                    foreach ($OriginalOrders as $order) {
                        $cart->getOrders()->add($order);
                    }
                }

                $form = $this->createForm(new CartType(), $cart);

                $form->handleRequest($request);

                if($form->isValid()) {
                    foreach ($OriginalOrders as $order) {
                        if (false === $cart->getOrders()->contains($order)) {
                            $em->remove($order);
                        } else {
                        }
                    }
                    $newOrders = $form["orders"];


                    foreach($newOrders as $newOrder) {
                        $dish_id = $newOrder->get('dish_id')->getData();
                        $order = $newOrder->getData();

                        $quantity = $order->getQuantity();

                        if($quantity > 0 && $quantity < 1000) {
                            $dish = $this->getDoctrine()
                                ->getRepository('FoodBundle:Dish')->find($dish_id);

                            $order->setDish($dish);
                            $order->setUser($user);
                            $order->setEvent($event);
                            $order->setPricePerUnit($dish->getPrice());
                            $em->persist($order);
                        }
                    }

                    $em->flush();

                    /* NEED TO REDIRECT!!!!!!!!!*/
                }


                return $this->render('@Event/Default/pick.html.twig', array(
                    'event_name' => $event_name,
                    'dealer' =>  $dealer_name,
                    'dishes' => $dishes,
                    'orders' => $OriginalOrders,
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
                    $em = $this->getDoctrine()->getManager();

                    /*Calculating how many people ordered food*/
                    $query = $em->createQuery(
                        'SELECT COUNT(DISTINCT o.user)
                        FROM EventBundle:Order o
                        WHERE o.event = :event'
                    )->setParameter('event',$event->getId());
                    $people_count = $query->getSingleScalarResult();
                    /*----------------------------------------------*/

                    /* Selecting grouped data of orders */
                    $query = $em->createQuery(
                        'SELECT o orders, SUM(o.quantity) quantity_sum, SUM(o.pricePerUnit*o.quantity) price_sum
                        FROM EventBundle:Order o
                        WHERE o.event = :event
                        GROUP BY o.dish'
                    )->setParameter('event',$event->getId());

                    $orders = $query->getResult();
                    /*----------------------------*/


                    /* Get dealer name*/
                    $dealer_id =  $event->getDealer();
                    $dealer = $this->getDoctrine()
                        ->getRepository('FoodBundle:Dealer')->find($dealer_id);
                    $dealer_name = $dealer->getName();
                    /*--------------------------------*/


                    


                    $form = $this->createFormBuilder()
                        ->add('dueDate', 'datetime', array('data' => new \DateTime()))
                        ->add('save', 'submit', array('label' => 'Save'))
                        ->getForm();

                    return $this->render('EventBundle:Default:order.html.twig', array(
                        'event' => $event,
                        'dealer' =>  $dealer_name,
                        'people_count' => $people_count,
                        'orders' => $orders,
                        'form' => $form->createView(),
                    ));
                }
            }

        } else {
            return $this->redirectToRoute('corvus_main');
        }
    }
}
