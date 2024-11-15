<?php

namespace App\Tests\Cards;

use PHPUnit\Framework\TestCase;
use App\Cards\DeckOfCards;
use App\Cards\CardGraphic;
use Exception;

class DeckOfCardsTest extends TestCase
{
    public function testInitialDeckCount(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $this->assertEquals(52, $deck->cardCount());
    }

    public function testDrawCard(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $card = $deck->drawCard();
        $this->assertInstanceOf(CardGraphic::class, $card);
        $this->assertEquals(51, $deck->cardCount());
    }

    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $cardsBeforeShuffle = $deck->getCards();
        $deck->shuffle();
        $cardsAfterShuffle = $deck->getCards();
        $this->assertNotEquals($cardsBeforeShuffle, $cardsAfterShuffle);
    }

    public function testGetCards(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $cards = $deck->getCards();
        $this->assertCount(52, $cards);
        $this->assertInstanceOf(CardGraphic::class, $cards[0]);
    }

    public function testCardCount(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $this->assertEquals(52, $deck->cardCount());
        $deck->drawCard();
        $this->assertEquals(51, $deck->cardCount());
    }

    public function testSortDeck(): void
    {
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $deck->shuffle();
        $deck->sort();
        $cards = $deck->getCards();
        $this->assertEquals('2', $cards[0]->getValue());
        $this->assertEquals('spade Ace', $cards[51]->getAsString());
    }

    public function testDrawCardException(): void
    {
        $this->expectException(Exception::class);
        $deck = new DeckOfCards();
        $deck->drawCard();
    }
}
