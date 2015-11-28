<?php

namespace Corvus\EventBundle\Controller;

use Corvus\EventBundle\Entity\Cart;
use Corvus\EventBundle\Entity\Order;
use Corvus\EventBundle\Form\Type\CartType;
use Corvus\FoodBundle\Entity\Dish;
use Corvus\EventBundle\Form\Type\OrderType;
use Corvus\MainBundle\Entity\User;
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
