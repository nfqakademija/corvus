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
     * @ORM\Column(type="integer", name="user_id")
     * @ORM\Id
     */
    protected $userId;

    /**
     * @ORM\Column(type="integer", name="event_id")
     * @ORM\Id
     */
    protected $eventId;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return EventUser
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
     * @return EventUser
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
}
