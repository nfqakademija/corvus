<?php

namespace Corvus\EventBundle\Controller;

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

        if ($isFullyAuthenticated) {
            $event = $this->getDoctrine()
                ->getRepository('EventBundle:Event')
                ->find($id);

            if (!$event) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            } else {

                $dealer_id =  $event->getDealer();
                $event_name = $event->getTitle();

                $dealer = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dealer')->find($dealer_id);


                $dealer_name = $dealer->getName();

                $dishes = $this->getDoctrine()
                    ->getRepository('FoodBundle:Dish')->findBy(array('dealer' => $dealer_id));

                return $this->render('EventBundle:Default:index.html.twig', array(
                    'event_name' => $event_name,
                    'dealer' =>  $dealer_name,
                    'dishes' => $dishes
                ));
            }
        } else {
            return $this->redirectToRoute('corvus_main');
        }
    }
}
