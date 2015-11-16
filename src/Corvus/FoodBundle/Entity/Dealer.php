<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/6/2015
 * Time: 12:25 AM
 */

namespace Corvus\FoodBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dealer")
 */
class Dealer
{
    /**
     * @ORM\OneToMany(targetEntity = "Dish", mappedBy = "dealer")
     */
    protected $dishes;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="integer", unique=true, name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, name="name")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, name="phone")
     * @var string
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255, name="address")
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255, name="email")
     * @var string
     */
    protected $email;

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
     * Set name
     *
     * @param string $name
     *
     * @return Dealer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Dealer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Dealer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Dealer
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

    public  function __toString(){
        return $this->name;
    }
}
