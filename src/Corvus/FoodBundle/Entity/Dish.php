<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/6/2015
 * Time: 12:33 AM
 */

namespace Corvus\FoodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dish")
*/
class Dish
{
    /**
     * @ORM\Column(type="integer", unique=true, name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Dealer", inversedBy = "dishes")
     * @ORM\JoinColumn(name = "dealer_id", referencedColumnName = "id")
     * @var Dealer
     */
    protected $dealer;

    /**
     * @ORM\Column(type="string", name="name", length=255)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="image_link", length=255)
     * @var string
     */
    protected $imageLink;

    /**
     * @ORM\Column(type="float", name="price")
     * @var float
     */
    protected $price;

    /**
     * @ORM\Column(type="boolean", name="removed_from_menu", nullable=true)
     * @var boolean
     */
    protected $removedFromMenu;

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
     * Set name
     *
     * @param string $name
     *
     * @return Dish
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
     * Set imageLink
     *
     * @param string $imageLink
     *
     * @return Dish
     */
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * Get imageLink
     *
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Dish
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set removedFromMenu
     *
     * @param boolean $removedFromMenu
     *
     * @return Dish
     */
    public function setRemovedFromMenu($removedFromMenu)
    {
        $this->removedFromMenu = $removedFromMenu;

        return $this;
    }

    /**
     * Get removedFromMenu
     *
     * @return boolean
     */
    public function getRemovedFromMenu()
    {
        return $this->removedFromMenu;
    }

    /**
     * Set dealer
     *
     * @param \Corvus\FoodBundle\Entity\Dealer $dealer
     *
     * @return Dish
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
}
