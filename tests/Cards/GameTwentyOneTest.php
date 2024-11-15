<?php

namespace App\Tests\Cards;

use PHPUnit\Framework\TestCase;
use App\Cards\GameTwentyOne;
use App\Cards\CardGraphic;

class GameTwentyOneTest extends TestCase
{
    public function testInitialScores(): void
    {
        $game = new GameTwentyOne();
        $this->assertEquals(0, $game->getPlayerScore());
        $this->assertEquals(0, $game->getDealerScore());
    }

    public function testDrawPlayerCard(): void
    {
        $game = new GameTwentyOne();
        $game->drawPlayerCard();
        $this->assertGreaterThan(0, $game->getPlayerScore());
        $this->assertCount(1, $game->getPlayerHand());
    }

    public function testDrawDealerCard(): void
    {
        $game = new GameTwentyOne();
        $game->drawDealerCard();
        $this->assertGreaterThan(0, $game->getDealerScore());
        $this->assertCount(1, $game->getDealerHand());
    }

    public function testGetPlayerHand(): void
    {
        $game = new GameTwentyOne();
        $game->drawPlayerCard();
        $hand = $game->getPlayerHand();
        $this->assertCount(1, $hand);
        $this->assertInstanceOf(CardGraphic::class, $hand[0]);
    }

    public function testGetDealerHand(): void
    {
        $game = new GameTwentyOne();
        $game->drawDealerCard();
        $hand = $game->getDealerHand();
        $this->assertCount(1, $hand);
        $this->assertInstanceOf(CardGraphic::class, $hand[0]);
    }

    public function testGetDeckCount(): void
    {
        $game = new GameTwentyOne();
        $initialDeckCount = $game->getDeckCount();
        $game->drawPlayerCard();
        $this->assertEquals($initialDeckCount - 1, $game->getDeckCount());
    }

    public function testIsGameOver(): void
    {
        $game = new GameTwentyOne();
        $this->assertFalse($game->isGameOver());

        while ($game->getPlayerScore() < 21) {
            $game->drawPlayerCard();
        }
        $this->assertTrue($game->isGameOver());
    }

    public function testDetermineWinner(): void
    {
        $game = new GameTwentyOne();

        while ($game->getPlayerScore() <= 21) {
            $game->drawPlayerCard();
        }
        $this->assertEquals('Dealer wins!', $game->determineWinner());

        $game = new GameTwentyOne();

        while ($game->getDealerScore() <= 21) {
            $game->drawDealerCard();
        }
        $this->assertEquals('Player wins!', $game->determineWinner());

        $game = new GameTwentyOne();

        $game->drawPlayerCard();
        $game->drawPlayerCard();
        $this->assertEquals('Player wins!', $game->determineWinner());

        $game = new GameTwentyOne();
        $this->assertEquals('Dealer wins!', $game->determineWinner());

        $game = new GameTwentyOne();
        $game->drawDealerCard();
        $this->assertEquals('Dealer wins!', $game->determineWinner());

        $game = new GameTwentyOne();
        for ($i = 0; $i < 40; $i++) {
            $game->drawPlayerCard();
        }
        for ($i = 0; $i < 12; $i++) {
            $game->drawDealerCard();
        }
        $this->assertEquals('Dealer wins!', $game->determineWinner());
    }
}
