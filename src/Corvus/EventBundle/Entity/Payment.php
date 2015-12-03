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
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\MainBundle\Entity\User", inversedBy = "payments")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity = "Event", inversedBy = "payments")
     * @ORM\JoinColumn(name = "event_id", referencedColumnName = "id")
     * @var Event
     */
    protected $event;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, name="paid")
     * @var float
     */
    protected $paid;

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
     * Set paid
     *
     * @param float $paid
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
     * @return float
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set user
     *
     * @param \Corvus\MainBundle\Entity\User $user
     *
     * @return Payment
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
     * @return Payment
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
