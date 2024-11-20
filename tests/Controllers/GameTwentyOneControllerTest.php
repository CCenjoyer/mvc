<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameTwentyOneControllerTest extends WebTestCase
{
    public function testGameDocs(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/doc');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Twenty One Docs');
    }

    public function testGameInfo(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Twenty One');
    }

    public function testGameReset(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/reset');

        $this->assertResponseRedirects('/game/play');
    }

    public function testGame(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/play');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Twenty-One Game');
    }
}