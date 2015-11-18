<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/5/2015
 * Time: 1:32 AM
 */

namespace Corvus\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_user")
 */
class EventUser
{
    /**
     * @ORM\ManyToOne(targetEntity = "Corvus\MainBundle\Entity\User", inversedBy = "events")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id")
     * @ORM\Id
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity = "Event", inversedBy = "users")
     * @ORM\JoinColumn(name = "event_id", referencedColumnName = "id")
     * @ORM\Id
     * @var Event
     */
    protected $event;

    /**
     * Set user
     *
     * @param \Corvus\MainBundle\Entity\User $user
     *
     * @return EventUser
     */
    public function setUser(\Corvus\MainBundle\Entity\User $user)
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
     * @return EventUser
     */
    public function setEvent(\Corvus\EventBundle\Entity\Event $event)
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
