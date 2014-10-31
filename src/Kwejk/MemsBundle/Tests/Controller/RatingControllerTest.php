<?php

namespace Kwejk\MemsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RatingControllerTest extends WebTestCase
{
    public function testAddrating()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addRating');
    }

}
