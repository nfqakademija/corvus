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
                $user = $this->container->get('security.context')->getToken()->getUser();
                $dealer_id = $event->getDealer();
                $event_name = $event->getTitle();

                $dealer = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dealer')->find($dealer_id);

                $dealer_name = $dealer->getName();

                $dishes = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dish')->findBy(array('dealer' => $dealer_id));


                $orders = $this->getDoctrine()
                    ->getRepository('EventBundle:Order')->findBy(array('event' => $event, 'user' => $user));


                $cart = new Cart();

                $order = new Order();

                if ($orders != null) {
                    foreach ($orders as $order) {
                        $cart->getOrders()->add($order);
                    }
                }



                $form = $this->createForm(new CartType(), $cart);


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
                        ->add('dueDate', 'date')
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
