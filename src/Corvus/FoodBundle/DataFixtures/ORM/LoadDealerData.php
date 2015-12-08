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
        $dealer->setName('Senoji kibininė');
        $dealer->setAddress('Karaimų g. 65, Trakai');
        $dealer->setEmail("senoji@kibinas.lt");
        $dealer->setPhone("+370 659 72132");
        $manager->persist($dealer);

        $dealer2 = new Dealer();
        $dealer2->setName('Visa pica');
        $dealer2->setAddress('Šilo g. 13a, Vilnius');
        $dealer2->setEmail("visapica@gmail.com");
        $dealer2->setPhone("+370 685 10505");
        $manager->persist($dealer2);

        $manager->flush();

        $this->addReference('d1', $dealer);
        $this->addReference('d2', $dealer2);
    }

    public function getOrder()
    {
        return 1;
    }
}