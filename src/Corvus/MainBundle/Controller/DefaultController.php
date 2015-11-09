<?php

namespace Corvus\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {

        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isFullyAuthenticated) {
            return $this->dashboardAction();
        } else{
            return $this->welcomeAction();
        }
    }

    /**
     * @Route("/login")
     */
    public function welcomeAction(){
        return $this->render('CorvusMainBundle:welcome:welcome.html.twig');
    }

    /**
     * @Route("/dashboard")
     */
    public function dashboardAction(){
        return $this->render('CorvusMainBundle:welcome:dashboard.html.twig');
    }
}
