<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.06
 * Time: 15:58
 */


// src/AppBundle/Entity/User.php

namespace Corvus\MainBundle\Entity;

use Corvus\EventBundle\Entity\Payment;
use Corvus\EventBundle\Entity\Event;
use Corvus\EventBundle\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Corvus\EventBundle\Entity\Event", mappedBy="users")
     * @var Event[]|ArrayCollection
     */
    protected $events;

    /**
     * @ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\Event", mappedBy="host")
     * @var Event[]|ArrayCollection
     */
    protected $eventsHost;

    /**
     * @ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\Payment", mappedBy="user")
     * @var Payment[]|ArrayCollection
     */
    protected $payments;

    /**
     * @ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\Order", mappedBy="user")
     * @var Order[]|ArrayCollection
     */
    protected $orders;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->events = new ArrayCollection();
        $this->eventsHost = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add eventsHost
     *
     * @param \Corvus\EventBundle\Entity\Event $eventsHost
     *
     * @return User
     */
    public function addEventsHost(\Corvus\EventBundle\Entity\Event $eventsHost)
    {
        $this->eventsHost[] = $eventsHost;

        return $this;
    }

    /**
     * Remove eventsHost
     *
     * @param \Corvus\EventBundle\Entity\Event $eventsHost
     */
    public function removeEventsHost(\Corvus\EventBundle\Entity\Event $eventsHost)
    {
        $this->eventsHost->removeElement($eventsHost);
    }

    /**
     * Get eventsHost
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventsHost()
    {
        return $this->eventsHost;
    }

    /**
     * Add payment
     *
     * @param \Corvus\EventBundle\Entity\Payment $payment
     *
     * @return User
     */
    public function addPayment(\Corvus\EventBundle\Entity\Payment $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * Remove payment
     *
     * @param \Corvus\EventBundle\Entity\Payment $payment
     */
    public function removePayment(\Corvus\EventBundle\Entity\Payment $payment)
    {
        $this->payments->removeElement($payment);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Add order
     *
     * @param \Corvus\EventBundle\Entity\Order $order
     *
     * @return User
     */
    public function addOrder(\Corvus\EventBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Corvus\EventBundle\Entity\Order $order
     */
    public function removeOrder(\Corvus\EventBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add event
     *
     * @param \Corvus\EventBundle\Entity\Event $event
     *
     * @return User
     */
    public function addEvent(\Corvus\EventBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \Corvus\EventBundle\Entity\Event $event
     */
    public function removeEvent(\Corvus\EventBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }
}
