<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/14/2015
 * Time: 2:31 PM
 */

namespace Corvus\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_mail")
 */
class EventMail
{
    /**
     * @ORM\Column(type="integer", unique=true, name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManytoOne(targetEntity = "Event", inversedBy = "emails")
     * @ORM\JoinColumn(name = "event_id", referencedColumnName = "id")
     * @var Event
     */
    protected $event;

    /**
     * @ORM\Column(type="string", name="email", length=255)
     * @var string
     */
    protected $email;

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
     * Set email
     *
     * @param string $email
     *
     * @return EventMail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set event
     *
     * @param \Corvus\EventBundle\Entity\Event $event
     *
     * @return EventMail
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
