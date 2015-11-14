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
     * @var integer
     */
    protected $eventId;

    /**
     * @ORM\Column(type="string", name="email", length=255)
     */
    protected $email;
}