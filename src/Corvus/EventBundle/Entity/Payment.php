<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/6/2015
 * Time: 12:54 AM
 */

namespace Corvus\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="payment")
 */
class Payment
{
    /**
     * @ORM\Column(type="integer", unique=true, name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\MainBundle\Entity\User", inversedBy = "userPayments")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id")
     * @var integer
     */
    protected $userId;

    /**
     * @ORM\ManyToOne(targetEntity = "Event", inversedBy = "eventPayments")
     * @ORM\JoinColumn(name = "event_id", referencedColumnName = "id")
     * @var integer
     */
    protected $eventId;

    /**
     * @ORM\Column(type="integer", name="paid")
     */
    protected $paid;

    /**
     * Get paymentId
     *
     * @return integer
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Payment
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
     * @return Payment
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
     * Set paid
     *
     * @param integer $paid
     *
     * @return Payment
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return integer
     */
    public function getPaid()
    {
        return $this->paid;
    }
}
