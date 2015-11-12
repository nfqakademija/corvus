<?php

namespace Corvus\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class testController extends Controller
{
    /**
     * @Route("/Contacts")
     * @Template()
     */
    public function ContactsAction()
    {
        return array(
                // ...
            );    }

}
