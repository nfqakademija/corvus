<?php

namespace Corvus\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class Cart
{
    /**
     * @ORM\OneToMany(targetEntity="Order", cascade={"persist"})
     */
    protected $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function addOrder(Order $order)
    {
        $this->orders->add($order);
    }

    public function removeOrder(Order $order)
    {
        $this->orders->removeElement($order);
    }
}
