<?php

namespace Corvus\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class testControllerTest extends WebTestCase
{
    public function testContacts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Contacts');
	$heading = $crawler->filter('h1')->eq(0)->text();
	$this->assertEquals('Welcome to the test:Contacts page', $heading);
	
	
    }

}
