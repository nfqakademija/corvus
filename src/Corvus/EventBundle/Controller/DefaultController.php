<?php

namespace Corvus\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Corvus\EventBundle\Entity\Event;
use Corvus\EventBundle\Form\EventType;
use Corvus\EventBundle\Form\EditEventType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/event/new")
     * @Template()
     */
    public function createEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $event->setHost($this->getUser());
            foreach($event->getEmails() as $email){
                $count = 0;
                foreach($event->getEmails() as $emailDupe){
                    if(strtolower($email->getEmail()) == strtolower($emailDupe->getEmail())){
                        $count++;
                    }
                }
                if($count > 1){
                    $event->removeEmail($email);
                    continue;
                }
                $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->findOneBy(array('email' => $email->getEmail()));
                if($user){
                    $event->addUser($user);
                    $event->removeEmail($email);
                } else {
                    $email->setEvent($event);
                }
            }
            foreach($event->getEmails() as $email){
                $em->persist($email);
            }
            $em->persist($event);
            $em->flush();
            return $this->redirect($this->generateUrl('select_food'));
        }
        return array(
            'form' => $form->createView(),
        );
    }
    /**
     * @Route("/event/{id}/edit")
     * @Template()
     */
    public function editEventAction(Request $request, Event $event)
    {
        $form = $this->createForm(new EditEventType(), $event);

        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            foreach($event->getEmails() as $email){
                $count = 0;
                foreach($event->getEmails() as $emailDupe){
                    if(strtolower($email->getEmail()) == strtolower($emailDupe->getEmail())){
                        $count++;
                    }
                }
                foreach($event->getUsers() as $user){
                    if(strtolower($email->getEmail()) == strtolower($user->getEmail())){
                        $count++;
                    }
                }
                if($count > 1){
                    $event->removeEmail($email);
                    continue;
                }
                $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->findOneBy(array('email' => $email->getEmail()));
                if($user){
                    $event->addUser($user);
                    $event->removeEmail($email);
                } else {
                    $event->addEmail($email);
                }
            }

            foreach($event->getEmails() as $email){
                $email->setEvent($event);
                $em->persist($email);
            }

            $em->persist($event);
            $em->flush();
            return $this->redirect($this->generateUrl('dashboard'));
        }
        return array(
            'form' => $form->createView()
        );
    }
}
