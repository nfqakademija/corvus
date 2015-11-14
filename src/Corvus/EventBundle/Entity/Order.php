<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/6/2015
 * Time: 12:41 AM
 */

namespace Corvus\EventBundle\Entity;

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
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\FoodBundle\Entity\Dish")
     * @ORM\JoinColumn(name="dish_id", referencedColumnName = "id")
     * @var integer
     */
    protected $dishId;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\MainBundle\Entity\User", inversedBy = "userOrders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName = "id")
     * @var integer
     */
    protected $userId;

    /**
     * @ORM\ManyToOne(targetEntity = "Event", inversedBy = "eventOrders")
     * @ORM\JoinColumn(name="event_id", referencedColumnName = "id")
     * @var integer
     */
    protected $eventId;

    /**
     * @ORM\Column(type="integer", name="quantity")
     */
    protected $quantity;

    /**
     * @ORM\Column(type="integer", name="price_per_unit")
     */
    protected $pricePerUnit;

    /**
     * @ORM\Column(type="boolean", name="is_removed")
     */
    protected $isRemoved;

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set dishId
     *
     * @param integer $dishId
     *
     * @return Order
     */
    public function setDishId($dishId)
    {
        $this->dishId = $dishId;

        return $this;
    }

    /**
     * Get dishId
     *
     * @return integer
     */
    public function getDishId()
    {
        return $this->dishId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Order
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return Order
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->eventId;
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
}
