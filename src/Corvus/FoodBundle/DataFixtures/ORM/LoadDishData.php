<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.19
 * Time: 18:38
 */

namespace FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\FoodBundle\Entity\Dish;

class LoadDishData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $Dish = new Dish();
        $Dish->setName("testuojam");
        $Dish->setCategory("BlaBla");
        $Dish->setPrice(16);
        $Dish->setImageLink("asdas");
        $Dish->setDealerId(1);
        $Dish->setRemovedFromMenu(false);


        $manager->persist($Dish);

        $Dish = new Dish();
        $Dish->setName("picaa");
        $Dish->setCategory("BlaBla");
        $Dish->setPrice(15);
        $Dish->setImageLink("asdas");
        $Dish->setDealerId(1);
        $Dish->setRemovedFromMenu(false);

        $manager->persist($Dish);
        $manager->flush();
    }
}