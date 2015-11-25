<?php
/**
 * Created by PhpStorm.
 * User: Vartotojas
 * Date: 2015.11.19
 * Time: 18:38
 */

namespace FoodBundle\DataFixtures\ORM;

use Corvus\FoodBundle\Entity\Dealer;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\FoodBundle\Entity\Dish;

class LoadDealerData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dealer = new Dealer();

        $dealer->setAddress("Vilnius");
        $dealer->setEmail("email@email.com");
        $dealer->setName("Ciliaks");
        $dealer->setPhone("+37066666666");

        $manager->persist($dealer);
        $manager->flush();
    }
}