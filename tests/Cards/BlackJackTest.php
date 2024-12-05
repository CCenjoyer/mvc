<?php

namespace App\Tests\BlackJack;

use App\Cards\BlackJack;
use PHPUnit\Framework\TestCase;

class BlackJackTest extends TestCase
{
    public function testPlaceBet(): void
    {
        $game = new BlackJack(1, 100);
        $game->placeBet(0, 50);
        $this->assertEquals(50, $game->money);
        $this->assertEquals(50, $game->players[0]->getBet());
    }

    public function testDealInitialCards(): void
    {
        $game = new BlackJack(1, 100);
        $game->dealInitialCards();
        $this->assertCount(2, $game->players[0]->getHand()->getCards());
        $this->assertCount(2, $game->dealerHand->getCards());
    }

    public function testNextRound(): void
    {
        $game = new BlackJack(1, 100);
        $game->dealInitialCards();
        $game->nextRound();
        $this->assertEquals(0, $game->currentPlayerIndex);
        $game->players[0]->setScore(21);
        $game->dealerScore = 20;
        $game->nextRound();
        $game->dealerScore = 22;
        $game->nextRound();
        $game->players[0]->setScore(21);
        $game->dealerScore = 21;
        $game->nextRound();
    }

    public function testCheckPlayersTurnsOver(): void
    {
        $game = new BlackJack(1, 100);
        $game->dealInitialCards();
        $this->assertFalse($game->checkPlayersTurnsOver());
        $player = $game->players[0];
        $player->setStanding(true);
        $this->assertTrue($game->checkPlayersTurnsOver());
    }

    public function testGetDealerCards(): void
    {
        $game = new BlackJack(1, 100);
        $game->dealInitialCards();
        $this->assertCount(2, $game->dealerHand->getCards());
    }

    public function testNextTurn(): void
    {
        $game = new BlackJack(2, 100);
        $game->dealInitialCards();
        $this->assertEquals(0, $game->currentPlayerIndex);
        $game->nextTurn();
        $this->assertEquals(1, $game->currentPlayerIndex);
        $game->nextTurn();
        $this->assertEquals(0, $game->currentPlayerIndex);
    }

    public function testHit(): void
    {
        $game = new BlackJack(1, 100);
        $game->dealInitialCards();
        $game->hit();
        $this->assertCount(3, $game->players[0]->getHand()->getCards());
    }

    public function testStand(): void
    {
        $game = new BlackJack(1, 100);
        $game->stand();
        $this->assertTrue($game->players[0]->isStanding());
    }

    public function testDealerDraw(): void
    {
        $game = new BlackJack(1, 100);
        $this->assertEquals(0, $game->dealerScore);
        $game->dealerDraw();
        $this->assertGreaterThanOrEqual(17, $game->dealerScore);
    }

    public function testIsGameOver(): void
    {
        $game = new BlackJack(1, 100);
        $this->assertFalse($game->isGameOver());
        $game->money = 0;
        $this->assertTrue($game->isGameOver());
    }
}
