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
     * @ORM\Column(type="integer", unique=true, name="dish_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $dishId;

    /**
     * @ORM\Column(type="integer", name="dealer_id")
     */
    protected $dealerId;

    /**
     * @ORM\Column(type="string", name="name", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", name="image_link", length=255)
     */
    protected $imageLink;

    /**
     * @ORM\Column(type="string", name="category", length=255)
     */
    protected $category;

    /**
     * @ORM\Column(type="integer", name="price")
     */
    protected $price;

    /**
     * @ORM\Column(type="boolean", name="removed_from_menu")
     */
    protected $removedFromMenu;

    /**
     * Get dishId
     *
     * @return integer
     */
    public function getDishId()
    {
        return $this->dishId;
    }

    /**
     * Set dealerId
     *
     * @param integer $dealerId
     *
     * @return Dish
     */
    public function setDealerId($dealerId)
    {
        $this->dealerId = $dealerId;

        return $this;
    }

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
     * Set category
     *
     * @param string $category
     *
     * @return Dish
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param integer $price
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
     * @return integer
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
}
