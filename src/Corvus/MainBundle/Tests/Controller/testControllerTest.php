<?php

namespace Corvus\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class testControllerTest extends WebTestCase
{
    public function testContacts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Contacts');
    }

}
