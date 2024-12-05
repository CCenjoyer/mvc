<?php

namespace App\Tests\BlackJack;

use App\Cards\BlackJackPlayer;
use App\Cards\DeckOfCards;
use App\Cards\CardGraphic;
use PHPUnit\Framework\TestCase;

class BlackJackPlayerTest extends TestCase
{
    public function testGetScore(): void
    {
        $player = new BlackJackPlayer();
        $player->setScore(21);
        $this->assertEquals(21, $player->getScore());
    }

    public function testAddCard(): void
    {
        $player = new BlackJackPlayer();

        $card = new CardGraphic('heart', 10);
        $player->addCard($card);
        $this->assertCount(1, $player->getHand()->getCards());

        $card = new CardGraphic('heart', 14);
        $player->addCard($card);
        $this->assertTrue($player->isStanding);

        $card = new CardGraphic('heart', 10);
        $player->addCard($card);
        $player->addCard($card);
        $this->assertTrue($player->isBust());
    }

    public function testClearHand(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $player = new BlackJackPlayer();
        $player->getHand()->addCard($deck->drawCard());
        $player->clearHand();
        $this->assertCount(0, $player->getHand()->getCards());
    }

    public function testGetCards(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $player = new BlackJackPlayer();
        $player->getHand()->addCard($deck->drawCard());
        $this->assertCount(1, $player->getCards());
    }

    public function testSetBet(): void
    {
        $player = new BlackJackPlayer();
        $player->setBet(50);
        $this->assertEquals(50, $player->getBet());
    }

    public function testSetBust(): void
    {
        $player = new BlackJackPlayer();
        $player->setBust(true);
        $this->assertTrue($player->isBust());
    }

    public function testSetStanding(): void
    {
        $player = new BlackJackPlayer();
        $player->setStanding(true);
        $this->assertTrue($player->isStanding());
    }

    public function testReset(): void
    {
        $player = new BlackJackPlayer();
        $player->setScore(21);
        $player->setBet(50);
        $player->setStanding(true);
        $player->setBust(true);
        $player->reset();

        $this->assertEquals(0, $player->getScore());
        $this->assertEquals(0, $player->getBet());
        $this->assertFalse($player->isStanding());
        $this->assertFalse($player->isBust());
        $this->assertCount(0, $player->getHand()->getCards());
    }
}
