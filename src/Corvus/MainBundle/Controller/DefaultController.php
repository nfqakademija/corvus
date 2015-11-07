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
        return array('name' => 'World');
    }

    public function welcomeAction(){
        return $this->render('CorvusMainBundle:welcome:welcome.html.twig');
    }
}
