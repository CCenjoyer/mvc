<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiceGameControllerTest extends WebTestCase
{
    public function testInitCallback(): void
    {
        $client = static::createClient();
        $client->request('POST', '/game/pig/init', ['num_dices' => 2]);

        $this->assertResponseRedirects('/game/pig/play');
    }

    public function testTestRollDice(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/roll');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Roll a dice');
    }

    public function testTestRollDices(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/roll/5');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Roll many dice');
    }

    public function testTestRollDicesException(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/roll/100');

        $this->assertResponseStatusCodeSame(500);
    }

    public function testTestDiceHand(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/dicehand/5');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Roll dice hand');
    }

    public function testTestDiceHandException(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/dicehand/100');

        $this->assertResponseStatusCodeSame(500);
    }
}