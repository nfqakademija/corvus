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
     * @var Host
     */
    protected $host;

    /**
     * @ORM\ManyToOne(targetEntity="Corvus\FoodBundle\Entity\Dealer")
     * @ORM\JoinColumn(name = "dealer_id", referencedColumnName = "id")
     * @var Dealer
     */
    protected $dealer;

    /**
     * @ORM\Column(type="string", length=255, name="title")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="datetime", name="end_date_time")
     */
    protected $endDateTime;

    /**
     * @ORM\Column(type="integer", name="status")
     * @var integer
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean", name="is_deleted")
     */
    protected $isDeleted;

    /**
     *  @ORM\ManyToMany(targetEntity="Corvus\MainBundle\Entity\User", mappedBy="events")
     * @var User[]|ArrayCollection
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity = "EventMail", mappedBy="event")
     * @var string
     */
    protected $emails;

    /**
     * @ORM\OneToMany(targetEntity = "Payment", mappedBy="event")
     * @var Payment[]|ArrayCollection
     */
    protected $payments;

    /**
     * @ORM\OneToMany(targetEntity = "Order", mappedBy = "event")
     * @var Order[]|ArrayCollection
     */
    protected $orders;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

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
     * Set status
     *
     * @param integer $status
     *
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
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

    /**
     * Set host
     *
     * @param \Corvus\MainBundle\Entity\User $host
     *
     * @return Event
     */
    public function setHost(\Corvus\MainBundle\Entity\User $host = null)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return \Corvus\MainBundle\Entity\User
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set dealer
     *
     * @param \Corvus\FoodBundle\Entity\Dealer $dealer
     *
     * @return Event
     */
    public function setDealer(\Corvus\FoodBundle\Entity\Dealer $dealer = null)
    {
        $this->dealer = $dealer;

        return $this;
    }

    /**
     * Get dealer
     *
     * @return \Corvus\FoodBundle\Entity\Dealer
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add email
     *
     * @param \Corvus\EventBundle\Entity\EventMail $email
     *
     * @return Event
     */
    public function addEmail(\Corvus\EventBundle\Entity\EventMail $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \Corvus\EventBundle\Entity\EventMail $email
     */
    public function removeEmail(\Corvus\EventBundle\Entity\EventMail $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add payment
     *
     * @param \Corvus\EventBundle\Entity\Payment $payment
     *
     * @return Event
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
     * @return Event
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
     * Add user
     *
     * @param \Corvus\MainBundle\Entity\User $user
     *
     * @return Event
     */
    public function addUser(\Corvus\MainBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Corvus\MainBundle\Entity\User $user
     */
    public function removeUser(\Corvus\MainBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }
}
