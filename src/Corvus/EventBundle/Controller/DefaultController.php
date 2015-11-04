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
}
