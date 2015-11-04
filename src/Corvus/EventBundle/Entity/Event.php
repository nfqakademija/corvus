<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/5/2015
 * Time: 1:06 AM
 */
namespace Corvus\EventBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Column(type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $event_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $host_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $dealer_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $end_date_time;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_deleted;
}