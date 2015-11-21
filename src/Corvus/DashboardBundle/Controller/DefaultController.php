<?php

namespace Corvus\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard/")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository('CorvusMainBundle:User')->find($id);

        $event_host_cnt = $user->getEventsHost()->count();
        $even_cnt = $user->getEvents()->count();

        //return $this->render('CorvusMainBundle:welcome:dashboard.html.twig', array('user_id' => $id));
        return array('name' => $id, 'count' => $event_host_cnt, 'ecount' => $even_cnt);
    }
}
