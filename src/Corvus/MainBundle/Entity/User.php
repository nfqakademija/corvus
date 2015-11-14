<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.06
 * Time: 15:58
 */


// src/AppBundle/Entity/User.php

namespace Corvus\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\EventUser", mappedBy="userId")
     */
    protected $eventUsers;

    /**
     * @ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\Event", mappedBy="hostId")
     */
    protected $eventsHost;

    /**
     * @ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\Payment", mappedBy="userId")
     */
    protected $userPayments;

    /**
     * @var@ORM\OneToMany(targetEntity="Corvus\EventBundle\Entity\Order", mappedBy="userId")
     */
    protected $userOrders;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->eventUsers = new ArrayCollection();
        $this->eventsHost = new ArrayCollection();
        $this->userPayments = new ArrayCollection();
        $this->userOrders = new ArrayCollection();
    }
}