<?php

/**
 * Created by PhpStorm.
 * User: vsks-NFQ-academy
 * Date: 11/21/2015
 * Time: 18:52
 */

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Corvus\MainBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setEmail('jog.andrius@gmail.com');
        $user1->setUsername('vaskas');
        $user1->setEnabled(true);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user1, '123');
        $user1->setPassword($password);

        $manager->persist($user1);
        $manager->flush();

        $user2 = new User();
        $user2->setEmail('vaskas.a@gmail.com');
        $user2->setUsername('vaskas1');
        $user2->setEnabled(true);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user2, '123');
        $user2->setPassword($password);

        $manager->persist($user2);
        $manager->flush();

        $user3 = new User();
        $user3->setEmail('ly5va@gmail.com');
        $user3->setUsername('vaskas3');
        $user3->setEnabled(true);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user3, '123');
        $user3->setPassword($password);

        $manager->persist($user3);
        $manager->flush();

        $this->addReference('u1', $user1);
        $this->addReference('u2', $user2);
        $this->addReference('u3', $user3);
    }

    public function getOrder()
    {
        return 1;
    }
}