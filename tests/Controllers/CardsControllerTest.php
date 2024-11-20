<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardsControllerTest extends WebTestCase
{
    public function testInit(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/init');

        $this->assertResponseRedirects('/card');
    }

    public function testCard(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Card Hand');
    }

    public function testDeck(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Deck');
    }

    public function testDrawCard(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck/draw');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Drawn Card:');
    }

    public function testDrawMultipleCards(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck/draw/3');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Drawn Cards:');
    }
}
