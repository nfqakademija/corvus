<?php

namespace Corvus\EventBundle\Controller;

use Corvus\EventBundle\Entity\Cart;
use Corvus\EventBundle\Entity\Order;
use Corvus\EventBundle\Form\Type\CartType;
use Corvus\EventBundle\Form\Type\MissingDishCheckType;
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
        return ['name' => $id];
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

                if(!$event->getUsers()->contains($user))
                {
                    throw $this->createNotFoundException(
                        'You are not in this event'.$id
                    );
                }

                $em = $this->getDoctrine()->getManager();

                $dealer_id = $event->getDealer();
                $event_name = $event->getTitle();

                $dealer = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dealer')->find($dealer_id);

                $dealer_name = $dealer->getName();

                $dishes = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dish')->findBy(['dealer' => $dealer_id]);

                $OriginalOrders = $this->getDoctrine()
                    ->getRepository('EventBundle:Order')->findBy(['event' => $event, 'user' => $user]);

                $cart = new Cart();

                if ($OriginalOrders != null) {
                    foreach ($OriginalOrders as $order) {
                        $cart->getOrders()->add($order);
                    }
                }

                $form = $this->createForm(new CartType(), $cart);

                $form->handleRequest($request);

                if($form->isValid()) {
                    $newOrders = $form["orders"];
                    $matched = false;
                    foreach ($OriginalOrders as $order) {
                        foreach($newOrders as $newOrder){
                            if($order->getDish()->getId() == $newOrder->get('dish_id')->getData()){
                                $matched = true;
                            }
                            if($matched == false){
                                $em->remove($order);
                            }
                            $matched = false;
                        }
                    }

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
                    return $this->redirectToRoute('dashboard');
                }

                return $this->render('@Event/Default/pick.html.twig', [
                    'event_name' => $event_name,
                    'dealer' =>  $dealer_name,
                    'dishes' => $dishes,
                    'orders' => $OriginalOrders,
                    'form' => $form->createView(),
                ]);
            }
        } else {
            return $this->redirectToRoute('dashboard');
        }
    }

    /**
     * @Route("/event/{id}/order",name="order_food")
     *
     */
    public function orderAction($id, Request $request)
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
                    $event_host = $event->getHost();
                    $user =$this->get('security.context')->getToken()->getUser();

                    /*If current user is not this event host*/
                    if($event_host !== $user) {
                        throw $this->createNotFoundException(
                            'You are not host of this event ' . $event_status
                        );
                    } else {
                        $em = $this->getDoctrine()->getManager();

                        $people_count = $this->getDoctrine()
                            ->getRepository('EventBundle:Order')
                            ->getPeopleCountWhoOrdered($event);

                        $orders = $this->getDoctrine()
                            ->getRepository('EventBundle:Order')
                            ->getGroupedOrders($event);

                        /* Get dealer name*/
                        $dealer_id = $event->getDealer();
                        $dealer = $this->getDoctrine()
                            ->getRepository('FoodBundle:Dealer')->find($dealer_id);
                        $dealer_name = $dealer->getName();

                        /* Get dish id's. Used for form*/
                        $dish_ids = [];
                        foreach ($orders as $order) {
                            $dish = $order["orders"]->getDish()->getId();
                            $dish_ids[$dish] = false;
                        }

                        $form = $this->createForm(new MissingDishCheckType($dish_ids));

                        $form->handleRequest($request);

                        if ($form->isValid()) {
                            $event_orders = $event->getOrders();
                            $dish_ids = $form["dish_id"]->getData();

                            /*Checking if order with that dish_id need to be removed*/
                            foreach ($dish_ids as $dish_id => $statement) {
                                if ($statement === true) {
                                    foreach ($event_orders as $order) {
                                        $order_dish_id = $order->getDish()->getId();
                                        if ($order_dish_id === $dish_id) {
                                            $order->setIsRemoved(true);

                                            $em->persist($order);
                                        }
                                    }
                                }
                            }

                            $event->setDeliveryDateTime($form["dueDate"]->getData());
                            $event->setStatus(3);

                            $em->flush();
                        }

                        return $this->render('EventBundle:Default:order.html.twig', [
                            'event' => $event,
                            'dealer' => $dealer_name,
                            'people_count' => $people_count,
                            'orders' => $orders,
                            'form' => $form->createView(),
                        ]);
                    }
                }
            }
        } else {
            return $this->redirectToRoute('dashboard');
        }
    }
}
