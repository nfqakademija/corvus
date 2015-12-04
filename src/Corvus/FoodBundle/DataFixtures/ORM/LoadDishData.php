<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/21/2015
 * Time: 17:30
 */

namespace Corvus\FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\FoodBundle\Entity\Dish;

class LoadDishData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dish1 = new Dish();
        $dish1->setName('Pica MArgarita');
        $dish1->setDescription('Sūris, prieskoniai, raudonėlis');
        $dish1->setPrice(2.99);
        $dish1->setRemovedFromMenu(false);
        $dish1->setDealer($this->getReference('d1'));

        $manager->persist($dish1);
        $manager->flush();

        $dish2 = new Dish();
        $dish2->setName('Pica Čili');
        $dish2->setDescription('Kiaulienos faršas, pomidorų padažas, čili pipirai');
        $dish2->setPrice(4.99);
        $dish2->setRemovedFromMenu(false);
        $dish2->setDealer($this->getReference('d1'));

        $manager->persist($dish2);
        $manager->flush();

        $dish3 = new Dish();
        $dish3->setName('Frankfurto dešrainis');
        $dish3->setDescription('Naminė rūkyta dešrelė, padažai');
        $dish3->setPrice(1.99);
        $dish3->setRemovedFromMenu(false);
        $dish3->setDealer($this->getReference('d2'));

        $manager->persist($dish3);
        $manager->flush();

        $dish4 = new Dish();
        $dish4->setName('Mantingos Mėsainis');
        $dish4->setDescription('Jautienos faršas, druska, pipirai, sūris, salotos');
        $dish4->setPrice(3.99);
        $dish4->setRemovedFromMenu(false);
        $dish4->setDealer($this->getReference('d2'));

        $manager->persist($dish4);
        $manager->flush();

        $dish5 = new Dish();
        $dish5->setName('Itališkas sumuštinis');
        $dish5->setDescription('Virtas kumpis, kiaušinis, salotos, padažas');
        $dish5->setPrice(2.99);
        $dish5->setRemovedFromMenu(false);
        $dish5->setDealer($this->getReference('d2'));

        $manager->persist($dish5);
        $manager->flush();

        $this->addReference('f1', $dish1);
        $this->addReference('f2', $dish2);
        $this->addReference('f3', $dish3);
        $this->addReference('f4', $dish4);
        $this->addReference('f5', $dish5);
    }

    public function getOrder()
    {
        return 2;
    }
}