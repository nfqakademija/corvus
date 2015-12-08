<?php

namespace Corvus\EventBundle\Controller;

use Corvus\EventBundle\Entity\Cart;
use Corvus\EventBundle\Entity\Order;
use Corvus\EventBundle\Entity\Payment;
use Corvus\EventBundle\Event\SendMailsEvent;
use Corvus\EventBundle\EventEvents;
use Corvus\EventBundle\Form\Type\CartType;
use Corvus\EventBundle\Form\Type\MissingDishCheckType;
use Corvus\EventBundle\Form\Type\PaymentType;
use Corvus\FoodBundle\Entity\Dish;
use Corvus\MainBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Corvus\EventBundle\Entity\Event;
use Corvus\EventBundle\Form\EventType;
use Corvus\EventBundle\Form\EditEventType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/event/new")
     * @Template()
     */
    public function createEventAction(Request $request)
    {
        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        if ($isFullyAuthenticated) {
            $event = new Event();
            $form = $this->createForm(new EventType(), $event);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $event->setHost($this->getUser());
                foreach ($event->getEmails() as $email) {
                    $count = 0;
                    foreach ($event->getEmails() as $emailDupe) {
                        if (strtolower($email->getEmail()) == strtolower($emailDupe->getEmail())) {
                            $count++;
                        }
                    }
                    if ($count > 1) {
                        $event->removeEmail($email);
                        continue;
                    }

                    $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->findOneBy(['email' => $email->getEmail()]);

                    if ($user) {
                        $event->addUser($user);
                        $event->removeEmail($email);
                    } else {
                        $email->setEvent($event);
                    }
                }
                foreach ($event->getEmails() as $email) {
                    if (!$em->contains($email)) {
                        $em->persist($email);
                    }
                }

                $users = $event->getUsers();
                $emails = $event->getEmails();

                $dispatcher = $this->get('event_dispatcher');
                $dispatcher->dispatch(EventEvents::EVENT_CREATED, new SendMailsEvent($event, $users, $emails));

                $em->persist($event);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Event has been created. Time to pick some food!'
                );
                return $this->redirect($this->generateUrl('select_food', ['id' => $event->getId()]));
            }
            return [
                'form' => $form->createView()
            ];
        } else {
            return $this->redirectToRoute('dashboard');
        }
    }
    /**
     * @Route("/event/{id}/edit")
     * @Template()
     */
    public function editEventAction(Request $request, Event $event)
    {
        $isFullyAuthenticated = $this->get('security.context')
        ->isGranted('IS_AUTHENTICATED_FULLY');
        $userIsHost = ($event->getHost() === $this->getUser());
        if($isFullyAuthenticated && $userIsHost) {

            $OldDateTime = $event->getEndDateTime();
            $OldEmails =$this->getDoctrine()->getRepository('EventBundle:EventMail')->findBy(['event' => $event]);

            $form = $this->createForm(new EditEventType(), $event);
            $form->handleRequest($request);

            $users = new ArrayCollection();
            $emails = new ArrayCollection();

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $NewDateTime = $event->getEndDateTime();
                foreach ($event->getEmails() as $email) {
                    $count = 0;
                    foreach ($event->getEmails() as $emailDupe) {
                        if (strtolower($email->getEmail()) == strtolower($emailDupe->getEmail())) {
                            $count++;
                        }
                    }
                    foreach ($event->getUsers() as $user) {
                        if (strtolower($email->getEmail()) == strtolower($user->getEmail())) {
                            $count++;
                        }
                    }
                    if ($count > 1) {
                        $event->removeEmail($email);
                        continue;
                    }

                    $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->findOneBy(['email' => $email->getEmail()]);
                    if ($user) {
                        $event->addUser($user);
                        $event->removeEmail($email);

                        $users->add($user);
                    } else {

                        //Need to iterate through old emails and check if this email is already in the list.
                        $count = 0;
                        foreach($OldEmails as $OldEmail){
                            if(strtolower($OldEmail->getEmail()) == strtolower($email->getEmail())){
                                $count++;
                            }
                        }
                        if($count ==0){
                            $emails->add($email);
                        }

                        $event->addEmail($email);
                    }
                }

                $dispatcher = $this->get('event_dispatcher');
                if(!($OldDateTime == $NewDateTime)){
                    $dispatcher->dispatch(EventEvents::EVENT_EDITED_TIME_EXTENDED, new SendMailsEvent($event));
                }


                if($emails->count() == 0){
                    $emails = null;
                }

                if($users->count() == 0){
                    $users = null;
                }

                if($emails != null || $users != null) {
                    $dispatcher->dispatch(EventEvents::EVENT_EDITED_ADD_USERS, new SendMailsEvent($event, $users, $emails));
                }

                foreach ($event->getEmails() as $email) {
                    $email->setEvent($event);
                    $em->persist($email);
                }

                $em->persist($event);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Changes have been saved!'
                );

                return $this->redirect($this->generateUrl('dashboard'));
            }
            return [
                'form' => $form->createView()
            ];
        } else {
            return $this->redirectToRoute('dashboard');
        }
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
            if (!$event)
            {
                throw $this->createNotFoundException(
                    'No event found for id '.$id
                );
            } else
            {
                $user = $this->container->get('security.context')->getToken()->getUser();

                if(!$event->getUsers()->contains($user))
                {
                    if($event->getHost() != $user)
                    {
                        throw $this->createNotFoundException(
                            'You are not in this event' . $id
                        );
                    }
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

                if ($OriginalOrders != null)
                {
                    foreach ($OriginalOrders as $order)
                    {
                        $cart->getOrders()->add($order);
                    }
                }

                $form = $this->createForm(new CartType(), $cart);

                $form->handleRequest($request);

                if($form->isValid())
                {
                    $newOrders = $form["orders"];

                    /*For security purposes. In form every dish_id mustbe
                    recognizable in dishes. If not, that means someone changed dish id
                    in hidden form for purpose */
                    foreach ($newOrders as $newOrder)
                    {
                        $contains = false;
                        foreach ($dishes as $dish)
                        {
                            if($newOrder->get('dish_id')->getData() == $dish->getId())
                            {
                                $contains = true;
                            }
                        }
                        if($contains == false)
                        {
                            throw $this->createNotFoundException(
                                'Nah'
                            );
                        }
                    }

                    $matched = false;
                    foreach ($OriginalOrders as $order)
                    {
                        foreach($newOrders as $newOrder)
                        {
                            if($order->getDish()->getId() == $newOrder->get('dish_id')->getData())
                            {
                                $matched = true;
                            }
                            if($matched == false)
                            {
                                $em->remove($order);
                            }
                            $matched = false;
                        }
                    }

                    foreach($newOrders as $newOrder)
                    {
                        $dish_id = $newOrder->get('dish_id')->getData();
                        $order = $newOrder->getData();

                        $quantity = $order->getQuantity();

                        if($quantity > 0 && $quantity < 1000)
                        {
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

                    $this->addFlash(
                        'notice',
                        'Your cart for "'. $event->getTitle() . '" event has been saved!'
                    );

                    return $this->redirectToRoute('dashboard');
                }

                return $this->render('@Event/Default/pick.html.twig',
                    [
                    'event_name' => $event_name,
                    'dealer' =>  $dealer_name,
                    'dishes' => $dishes,
                    'orders' => $OriginalOrders,
                    'form' => $form->createView(),
                    ]
                );
            }
        } else
        {
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
        if ($isFullyAuthenticated)
        {
            $event = $this->getDoctrine()
                ->getRepository('EventBundle:Event')
                ->find($id);

            /* Throw exception if event with that id doesnt exists*/
            if (!$event)
            {
                throw $this->createNotFoundException(
                    'No event found for id '.$id
                );
            } else
            {
                $event_status =$event->getStatus();
                /* Status event must be 2, that means that event is suspend, time for order is out, now host must call
                for dealer and order food for real*/
                if($event_status != 2)
                {
                    throw $this->createNotFoundException(
                        'Event status is incorect '.$event_status
                    );
                } else
                {
                    $event_host = $event->getHost();
                    $user =$this->get('security.context')->getToken()->getUser();

                    /*If current user is not this event host*/
                    if($event_host !== $user)
                    {
                        throw $this->createNotFoundException(
                            'You are not a host of this event ' . $event_status
                        );
                    } else
                    {
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
                        foreach ($orders as $order)
                        {
                            $dish = $order["orders"]->getDish()->getId();
                            $dish_ids[$dish] = false;
                        }

                        $form = $this->createForm(new MissingDishCheckType($dish_ids));

                        $form->handleRequest($request);

                        if ($form->isValid())
                        {

                            $event_orders = $event->getOrders();
                            $dish_ids = $form["dish_id"]->getData();

                            /*Checking if order with that dish_id need to be removed*/
                            foreach ($dish_ids as $dish_id => $statement)
                            {
                                if ($statement === true)
                                {
                                    foreach ($event_orders as $order)
                                    {
                                        $order_dish_id = $order->getDish()->getId();

                                        if ($order_dish_id === $dish_id)
                                        {
                                            $order->setIsRemoved(true);
                                            $em->persist($order);
                                        }
                                    }
                                }
                            }

                            $event->setDeliveryDateTime($form["dueDate"]->getData());

                            $em->flush();

                            $dispatcher = $this->get('event_dispatcher');
                            $dispatcher->dispatch(EventEvents::EVENT_FOOD_ORDERED, new SendMailsEvent($event));

                            $em->flush();

                            $this->addFlash(
                                'notice',
                                'Changes have been saved, and emails to all event "' . $event->getTitle() .'" members have been sent'
                            );

                            return $this->redirectToRoute('dashboard');
                        }

                        return $this->render('EventBundle:Default:order.html.twig',
                            [
                            'event' => $event,
                            'dealer' => $dealer_name,
                            'people_count' => $people_count,
                            'orders' => $orders,
                            'form' => $form->createView(),
                            ]
                        );
                    }
                }
            }
        } else
        {
            return $this->redirectToRoute('dashboard');
        }
    }

    /**
     * @Route("/event/{id}/payments", name="payments")
     * @Template()
     */
    public function paymentsAction($id, Request $request)
    {
        $isFullyAuthenticated = $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');
        if ($isFullyAuthenticated)
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $event = $this->getDoctrine()->getRepository('EventBundle:Event')->find($id);
            if ($event != null) {
                if ($user == $event->getHost()) {
                    $orderedGuests = $this->getDoctrine()->getRepository('EventBundle:Event')->getUsersWithOrders($id);
                    $unpaidUserIds = [];
                    $unpaidGuests = new ArrayCollection();
                    foreach ($orderedGuests as $guest)
                    {
                        if ($guest[1] != $event->getHost()->getId())
                        {
                            $usr = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->find($guest[1]);
                            if (($event->getUserDebt($usr)) != 0.0)
                            {
                                $unpaidUserIds[$guest[1]] = 0;
                                $unpaidGuests->add($usr);
                            }
                        }
                    }

                    $form =$this->createForm(new PaymentType($unpaidUserIds));

                    $form->handleRequest($request);

                    if ($form->isValid()) {
                        $payments = $form['payment']->getData();
                        $em = $this->getDoctrine()->getEntityManager();
                        foreach ($payments as $unpaidUserId => $amount) {
                            if ($amount > 0)
                            {
                                $paidGuest = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->find($unpaidUserId);
                                $payment = $this->getDoctrine()->getRepository('EventBundle:Payment')->findOneBy(['event' => $event, 'user' => $paidGuest]);
                                if ($payment != null)
                                {
                                    $payment->setPaid($payment->getPaid() + $amount);
                                    $em->flush();
                                } else {
                                    $payment = new Payment();
                                    $payment->setEvent($event);
                                    $payment->setUser($paidGuest);
                                    $payment->setPaid($amount);
                                    $em->persist($payment);
                                    $em->flush();
                                }
                            }
                        }
                        $this->addFlash(
                            'notice',
                            'Payments have been saved!'
                        );
                        return $this->redirectToRoute('dashboard');
                    }

                    $request = new Request();
                    $request->setRequestFormat('from_payment');


                    $RemindButton = $this->remindDebtsAction($event->getId(), $request);


                    return [
                        'event' => $event,
                        'guests' => $unpaidGuests,
                        'form' => $form->createView(),
                        'Remind_button' => $RemindButton['form'],
                    ];
                } else {
                    throw $this->createAccessDeniedException("You shall not pass!");
                }
            } else {
                return $this->createAccessDeniedException("You shall not pass!");
            }
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/event/{id}/review", name="review")
     * @Template()
     * @param int
     */
    public function reviewAction($id)
    {
        $isFullyAuthenticated = $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');
        if ($isFullyAuthenticated)
        {
            $event = $this->getDoctrine()->getRepository("EventBundle:Event")->find($id);
            if ($event != null)
            {
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                if (($user == $event->getHost()) || ($event->getUsers()->contains($user)))
                {

                    return [
                        'event' => $event,
                        'users' => new ArrayCollection(array_merge([$event->getHost()], $event->getUsers()->toArray()))
                    ];
                } else {
                    throw $this->createAccessDeniedException('You shall not pass!');
                }
            } else {
                throw $this->createAccessDeniedException('You shall not pass!');
            }
        } else {
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/event/{id}/cancel", name="cancel_event")
     * @Template()
     *
     */
    public function cancelAction($id, Request $request)
    {
        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        /* If not logged in, user will be redirected*/
        if ($isFullyAuthenticated)
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
                if ($event->getHost() != $user) {
                    throw $this->createNotFoundException(
                        'You are not in this event' . $id
                    );
                } else {
                    //main code

                    $form = $this->createFormBuilder()
                        ->add('confirm', 'checkbox', [

                            'label'     => 'Confirm',
                            'required'  => false,
                            'data'      => false,
                        ])
                        ->add('save', 'submit', ['label' => 'Save'])
                        ->getForm();

                    $form->handleRequest($request);

                    if($form->isValid()){

                        $data = $form->getData();
                        $confirm = $data['confirm'];

                        if($confirm == true){
                            $dispatcher = $this->get('event_dispatcher');
                            $dispatcher->dispatch(EventEvents::EVENT_CANCEL, new SendMailsEvent($event));
                            $em = $this->getDoctrine()->getManager();

                            $em->persist($event);
                            $em->flush();
                        }
                        $this->addFlash(
                            'notice',
                            'Event has been canceled!'
                        );
                        return $this->redirectToRoute('dashboard');
                    }

                    return $this->render('@Event/Default/cancel.html.twig',
                        [
                            'event' => $event,
                            'form' => $form->createView(),
                        ]
                    );
                }
            }
        }
    }

    /**
     * @Route("remind/{id}",name="remind_debts")
     * @Template()
     */
    public function remindDebtsAction($id, Request $request)
    {

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('remind_debts',['id' => $id]))
            ->setData(['id' => $id])
            ->add('save', 'submit', ['label' => 'Remind To pay debts'])
            ->getForm();

        if($request->getRequestFormat() == 'from_payment') {
            return [
                'form' => $form->createView(),
            ];
        } else {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $event = $this->getDoctrine()->getRepository('EventBundle:Event')->find($id);
                $orderedGuests = $this->getDoctrine()->getRepository('EventBundle:Event')->getUsersWithOrders($id);
                $unpaidUserIds = [];
                $unpaidGuests = new ArrayCollection();
                foreach ($orderedGuests as $guest)
                {
                    if ($guest[1] != $event->getHost()->getId())
                    {
                        $usr = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->find($guest[1]);
                        if (($event->getUserDebt($usr)) != 0.0)
                        {
                            $unpaidGuests->add($usr);
                        }
                    }
                }

                foreach($unpaidGuests as $user){
                    $mailer=$this->get('mailer');
                    $email = $user->getEmail();
                    $message = $mailer->createMessage()
                        ->setSubject('You have unpaid debts')
                        ->setFrom('corvusfood@gmail.com')
                        ->setTo($email)
                        ->setBody(
                            $this->renderView(
                                '@Event/Emails/remindUserDebt.html.twig',
                                [
                                    'user' => $user,
                                    'event' => $event,
                                    'debt' => ($event->getUserDebt($usr)),
                                ]
                            ),
                            'text/html'
                        );
                    $mailer->send($message);
                }

                $this->addFlash(
                    'notice',
                    'Emails have been sent!'
                );

                return $this->redirectToRoute('payments',['id' => $id]);
            } else {
                return $this->redirectToRoute('dashboard');
            }
        }
    }

}
