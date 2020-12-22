<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BeerControllerTest extends WebTestCase
{
    public function testGetBeers()
    {
        $client = static::createClient();
        $client->request('GET','/beers');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}