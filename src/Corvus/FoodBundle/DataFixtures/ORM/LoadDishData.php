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
        $dish1->setName('Beef pizza');
        $dish1->setDescription('Buffalo mozzarella, fresh beef ham, canned cucumbers, cherry tomatoes.');
        $dish1->setPrice(6.5);
        $dish1->setRemovedFromMenu(false);
        $dish1->setDealer($this->getReference('d2'));

        $dish2 = new Dish();
        $dish2->setName('Basturma pizza');
        $dish2->setDescription('Buffalo mozzarella, basturma, cherry tomatoes.');
        $dish2->setPrice(6.5);
        $dish2->setRemovedFromMenu(false);
        $dish2->setDealer($this->getReference('d2'));

        $dish3 = new Dish();
        $dish3->setName('Chicken pizza');
        $dish3->setDescription('Fresh chicken fillet, canned pineapples, fresh tomatoes, mushrooms.');
        $dish3->setPrice(4.5);
        $dish3->setRemovedFromMenu(false);
        $dish3->setDealer($this->getReference('d2'));

        $dish4 = new Dish();
        $dish4->setName('Saliami pizza');
        $dish4->setDescription('Salami, fresh tomatoes, fresh leeks, fresh paprika, black olives.');
        $dish4->setPrice(4.5);
        $dish4->setRemovedFromMenu(false);
        $dish4->setDealer($this->getReference('d2'));

        $dish5 = new Dish();
        $dish5->setName('Four cheese pizza');
        $dish5->setDescription('"Rokiškis" fermentedcheese, goat-sheep cheese, feta, buffallo mozzarella, blue cheese, rucola.');
        $dish5->setPrice(5.5);
        $dish5->setRemovedFromMenu(false);
        $dish5->setDealer($this->getReference('d2'));

        $dish6= new Dish();
        $dish6->setName('Vegetarian pizza');
        $dish6->setDescription('"Rokiškis" fermented cheese, fresh tomatoes, fresh paprika, fresh peas, mushrooms, black olives.');
        $dish6->setPrice(3);
        $dish6->setRemovedFromMenu(false);
        $dish6->setDealer($this->getReference('d2'));

        $dish7 = new Dish();
        $dish7->setName('Kharcho soup');
        $dish7->setDescription('Beef, ox bone broth, fresh tomatoes, garlic pizza sauce.');
        $dish7->setPrice(3);
        $dish7->setRemovedFromMenu(false);
        $dish7->setDealer($this->getReference('d2'));

        $dish8 = new Dish();
        $dish8->setName('Pink soup');
        $dish8->setDescription('"Rokiškis" kefir for cold beet soup, cucumbers, spring onions, baked beets, potatoes, egg, dill.');
        $dish8->setPrice(3);
        $dish8->setRemovedFromMenu(false);
        $dish8->setDealer($this->getReference('d2'));

        $dish9 = new Dish();
        $dish9->setName('Homemade kvass');
        $dish9->setDescription('Bread, sugar, water.');
        $dish9->setPrice(2.5);
        $dish9->setRemovedFromMenu(false);
        $dish9->setDealer($this->getReference('d2'));

        $dish10 = new Dish();
        $dish10->setName('Coca Cola');
        $dish10->setDescription('');
        $dish10->setPrice(1.2);
        $dish10->setRemovedFromMenu(false);
        $dish10->setDealer($this->getReference('d2'));

        $dish11 = new Dish();
        $dish11->setName('Karaite mutton pasty "Kibinai"');
        $dish11->setDescription('Mutton meat, pastry, salt, spices.');
        $dish11->setPrice(2.1);
        $dish11->setRemovedFromMenu(false);
        $dish11->setDealer($this->getReference('d1'));

        $dish12 = new Dish();
        $dish12->setName('Karaite beef pasty "Kibinai"');
        $dish12->setDescription('Beef meat, pastry, salt, spices.');
        $dish12->setPrice(1.8);
        $dish12->setRemovedFromMenu(false);
        $dish12->setDealer($this->getReference('d1'));

        $dish13 = new Dish();
        $dish13->setName('Karaite pork pasty "Kibinai"');
        $dish13->setDescription('Pork meat, pastry, salt, spices.');
        $dish13->setPrice(1.3);
        $dish13->setRemovedFromMenu(false);
        $dish13->setDealer($this->getReference('d1'));

        $dish14 = new Dish();
        $dish14->setName('Karaite venison pasty "Kibinai"');
        $dish14->setDescription('Venison meat, pastry, salt, spices.');
        $dish14->setPrice(2.3);
        $dish14->setRemovedFromMenu(false);
        $dish14->setDealer($this->getReference('d1'));

        $dish15 = new Dish();
        $dish15->setName('Salmon carpaccio');
        $dish15->setDescription('Salmon, salad, salt, spices.');
        $dish15->setPrice(5.5);
        $dish15->setRemovedFromMenu(false);
        $dish15->setDealer($this->getReference('d1'));

        $dish16 = new Dish();
        $dish16->setName('Herring with hot potatoes');
        $dish16->setDescription('Herring fillet, egg, pickled onion, fresh tomatoes, pickled cucumber, olives, beetroots, hot potatoes.');
        $dish16->setPrice(3.2);
        $dish16->setRemovedFromMenu(false);
        $dish16->setDealer($this->getReference('d1'));

        $dish17 = new Dish();
        $dish17->setName('Herring with mushrooms');
        $dish17->setDescription('Herring fillets, fried mushrooms, onions.');
        $dish17->setPrice(1.9);
        $dish17->setRemovedFromMenu(false);
        $dish17->setDealer($this->getReference('d1'));

        $dish18 = new Dish();
        $dish18->setName('"Royal" cabbage soup');
        $dish18->setDescription('Cabbage soup with smoked bacon and boletus serwed in a bread bowl.');
        $dish18->setPrice(2.9);
        $dish18->setRemovedFromMenu(false);
        $dish18->setDealer($this->getReference('d1'));

        $dish19 = new Dish();
        $dish19->setName('Caraway-seed drink');
        $dish19->setDescription('');
        $dish19->setPrice(0.9);
        $dish19->setRemovedFromMenu(false);
        $dish19->setDealer($this->getReference('d1'));

        $dish20 = new Dish();
        $dish20->setName('Cranberry drink');
        $dish20->setDescription('');
        $dish20->setPrice(0.9);
        $dish20->setRemovedFromMenu(false);
        $dish20->setDealer($this->getReference('d1'));

        $manager->persist($dish1);
        $manager->persist($dish2);
        $manager->persist($dish3);
        $manager->persist($dish4);
        $manager->persist($dish5);
        $manager->persist($dish6);
        $manager->persist($dish7);
        $manager->persist($dish8);
        $manager->persist($dish9);
        $manager->persist($dish10);
        $manager->persist($dish11);
        $manager->persist($dish12);
        $manager->persist($dish13);
        $manager->persist($dish14);
        $manager->persist($dish15);
        $manager->persist($dish16);
        $manager->persist($dish17);
        $manager->persist($dish18);
        $manager->persist($dish19);
        $manager->persist($dish20);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
