<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/6/2015
 * Time: 12:41 AM
 */

namespace Corvus\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order
{
    /**
     * @ORM\Column(type="integer", unique=true, name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\FoodBundle\Entity\Dish")
     * @ORM\JoinColumn(name="dish_id", referencedColumnName = "id")
     * @var Dish
     */
    protected $dish;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\MainBundle\Entity\User", inversedBy = "orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName = "id")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity = "Event", inversedBy = "orders")
     * @ORM\JoinColumn(name="event_id", referencedColumnName = "id")
     * @var Event
     */
    protected $event;

    /**
     * @ORM\Column(type="integer", name="quantity", nullable=false)
     * @var integer
     */
    protected $quantity;

    /**
     * @ORM\Column(type="integer", name="price_per_unit")
     * @var float
     */
    protected $pricePerUnit;

    /**
     * @ORM\Column(type="boolean", name="is_removed", nullable=true)
     * @var boolean
     */
    protected $isRemoved;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Order
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set pricePerUnit
     *
     * @param integer $pricePerUnit
     *
     * @return Order
     */
    public function setPricePerUnit($pricePerUnit)
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    /**
     * Get pricePerUnit
     *
     * @return integer
     */
    public function getPricePerUnit()
    {
        return $this->pricePerUnit;
    }

    /**
     * Set isRemoved
     *
     * @param boolean $isRemoved
     *
     * @return Order
     */
    public function setIsRemoved($isRemoved)
    {
        $this->isRemoved = $isRemoved;

        return $this;
    }

    /**
     * Get isRemoved
     *
     * @return boolean
     */
    public function getIsRemoved()
    {
        return $this->isRemoved;
    }

    /**
     * Set dish
     *
     * @param \Corvus\FoodBundle\Entity\Dish $dish
     *
     * @return Order
     */
    public function setDish(\Corvus\FoodBundle\Entity\Dish $dish = null)
    {
        $this->dish = $dish;

        return $this;
    }

    /**
     * Get dish
     *
     * @return \Corvus\FoodBundle\Entity\Dish
     */
    public function getDish()
    {
        return $this->dish;
    }

    /**
     * Set user
     *
     * @param \Corvus\MainBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\Corvus\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Corvus\MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set event
     *
     * @param \Corvus\EventBundle\Entity\Event $event
     *
     * @return Order
     */
    public function setEvent(\Corvus\EventBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Corvus\EventBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
}
