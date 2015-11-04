<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/5/2015
 * Time: 1:32 AM
 */

namespace Corvus\EventBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_user")
 */
class EventUser
{
    /**
     * @ORM\Column(type=integer)
     */
    protected $user_id;

    /**
     * @ORM\Column(type=integer)
     */
    protected $event_id;

}