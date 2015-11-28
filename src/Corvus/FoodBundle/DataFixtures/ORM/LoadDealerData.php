<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/21/2015
 * Time: 17:07
 */

namespace Corvus\FoodBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\FoodBundle\Entity\Dealer;

class LoadDealerData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dealer = new Dealer();
        $dealer->setName('Kebabine');
        $dealer->setAddress('In Shehkine');
        $dealer->setEmail("kebab@one.lt");
        $dealer->setPhone("852223322");

        $manager->persist($dealer);
        $manager->flush();

        $this->addReference('d1', $dealer);

        $dealer2 = new Dealer();
        $dealer2->setName('Tashnilovka');
        $dealer2->setAddress('Stoties rajonas');
        $dealer2->setEmail("volodzia@mail.ru");
        $dealer2->setPhone("+37060012345");

        $manager->persist($dealer2);
        $manager->flush();

        $this->addReference('d2', $dealer2);
    }

    public function getOrder()
    {
        return 1;
    }
}