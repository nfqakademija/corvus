<?php

namespace Corvus\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Corvus\EventBundle\Entity\Event;
use Corvus\EventBundle\Form\EventType;
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
            $event->setStatus(1);
            $event->setHost($this->getUser());

            foreach($event->getEmails() as $email){
                $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->findBy(
                    array('email' => $email->getEmail()),
                    array(),
                    $limit = 1
                );
                if($user && is_array($user)){
                    $event->addUser($user[0]);
                    $event->removeEmail($email);
                } else {
                    $email->setEvent($event);
                    $em->persist($email);
                }
            }

            $em->persist($event);
            $em->flush();
            return $this->redirect($this->generateUrl('/'));
        }
        return array('form' => $form->createView());
    }
}
