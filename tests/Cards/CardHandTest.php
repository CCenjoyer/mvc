<?php

namespace App\Tests\Cards;

use PHPUnit\Framework\TestCase;
use App\Cards\CardGraphic;
use App\Cards\CardHand;

class CardHandTest extends TestCase
{
    public function testInitialCardCount(): void
    {
        $hand = new CardHand();
        $this->assertEquals(0, $hand->cardCount());
    }

    public function testAddCard(): void
    {
        $hand = new CardHand();
        $card = new CardGraphic();
        $hand->addCard($card);
        $this->assertEquals(1, $hand->cardCount());
    }

    public function testGetCards(): void
    {
        $hand = new CardHand();
        $card1 = new CardGraphic();
        $card2 = new CardGraphic();
        $hand->addCard($card1);
        $hand->addCard($card2);

        $cards = $hand->getCards();
        $this->assertCount(2, $cards);
        $this->assertSame($card1, $cards[0]);
        $this->assertSame($card2, $cards[1]);
    }

    public function testCardCount(): void
    {
        $hand = new CardHand();
        $this->assertEquals(0, $hand->cardCount());

        $card = new CardGraphic();
        $hand->addCard($card);
        $this->assertEquals(1, $hand->cardCount());

        $hand->addCard(new CardGraphic());
        $this->assertEquals(2, $hand->cardCount());
    }
}
