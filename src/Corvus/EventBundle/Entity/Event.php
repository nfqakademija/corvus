<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/5/2015
 * Time: 1:06 AM
 */
namespace Corvus\EventBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Column(type="integer", unique=true, name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\MainBundle\Entity\User", inversedBy = "eventsHost")
     * @ORM\JoinColumn(name = "host_id", referencedColumnName = "id")
     * @var integer
     */
    protected $hostId;

    /**
     * @ORM\ManyToOne(targetEntity="Corvus\FoodBundle\Entity\Dealer")
     * @ORM\JoinColumn(name = "dealer_id", referencedColumnName = "id")
     * @var integer
     */
    protected $dealerId;

    /**
     * @ORM\Column(type="string", length=255, name="title")
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime", name="end_date_time")
     */
    protected $endDateTime;

    /**
     * @ORM\Column(type="boolean", name="is_deleted")
     */
    protected $isDeleted;

    /**
     *  @ORM\OneToMany(targetEntity="EventUser", mappedBy="eventId")
     */
    protected $userEvents;

    /**
     * @ORM\OneToMany(targetEntity = "EventUser", mappedBy="eventId")
     */
    protected $emails;

    /**
     * @ORM\OneToMany(targetEntity = "Payment", mappedBy="eventId")
     */
    protected $eventPayments;

    /**
     * @ORM\OneToMany(targetEntity = "Order", mappedBy = "eventId")
     */
    protected $eventOrders;

    public function __construct()
    {
        $this->userEvents = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->eventPayments = new ArrayCollection();
        $this->eventOrders = new ArrayCollection();
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
     * Set hostId
     *
     * @param integer $hostId
     *
     * @return Event
     */
    public function setHostId($hostId)
    {
        $this->hostId = $hostId;

        return $this;
    }

    /**
     * Get hostId
     *
     * @return integer
     */
    public function getHostId()
    {
        return $this->hostId;
    }

    /**
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return Event
     */
    public function setDealerId($dealerId)
    {
        $this->dealerId = $dealerId;

        return $this;
    }

    /**
     * Get dealerId
     *
     * @return integer
     */
    public function getDealerId()
    {
        return $this->dealerId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set endDateTime
     *
     * @param \DateTime $endDateTime
     *
     * @return Event
     */
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    /**
     * Get endDateTime
     *
     * @return \DateTime
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Event
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
}
