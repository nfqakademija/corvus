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
    public function formAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $event->setStatus(1);
            $event->setHost($this->getUser());

            foreach($event->getEmails() as $email){

                $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->findBy(array('email' => $email->getEmail()))[0];
                if($user){
                    $event->addUser($user);
                    $event->removeEmail($email);
                } else {
                    $email->setEvent($event);
                    $em->persist($email);
                }
            }

            $em->persist($event);
            $em->flush();
            return $this->redirect($this->generateUrl('corvus_main'));
        }
        return array('form' => $form->createView());
    }
}
