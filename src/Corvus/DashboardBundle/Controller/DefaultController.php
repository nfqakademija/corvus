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
        return array('name' => 'Teassssser');
    }
}
