<?php
/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/21/2015
 * Time: 20:41
 */

namespace Corvus\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Corvus\EventBundle\Entity\Order;

class LoadOrderData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $order = new Order();
        $order->setEvent($this->getReference('e1'));
        $order->setDish($this->getReference('f1'));
        $order->setIsRemoved(false);
        $order->setQuantity(2);
        $order->setUser($this->getReference('u1'));
        $order->setPricePerUnit(3.99);

        $manager->persist($order);
        $manager->flush();

        $order = new Order();
        $order->setEvent($this->getReference('e1'));
        $order->setDish($this->getReference('f2'));
        $order->setIsRemoved(false);
        $order->setQuantity(1);
        $order->setUser($this->getReference('u2'));
        $order->setPricePerUnit(9.99);

        $manager->persist($order);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }

}