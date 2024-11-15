<?php

namespace App\Tests\Cards;

use PHPUnit\Framework\TestCase;
use App\Cards\Card;

class CardTest extends TestCase
{
    public function testInitialValues(): void
    {
        $card = new Card();
        $this->assertEquals("", $card->getSuit());
        $this->assertEquals(0, $card->getValue());
    }

    public function testAssignValue(): void
    {
        $card = new Card();
        $card->assignValue(10);
        $this->assertEquals(10, $card->getValue());
    }

    public function testAssignSuit(): void
    {
        $card = new Card();
        $card->assignSuit("Heart");
        $this->assertEquals("Heart", $card->getSuit());
    }

    public function testGetAsString(): void
    {
        $card = new Card();
        $card->assignSuit("Heart");
        $card->assignValue(10);
        $this->assertEquals("Heart 10", $card->getAsString());

        $card->assignValue(11);
        $this->assertEquals("Heart Jack", $card->getAsString());

        $card->assignValue(12);
        $this->assertEquals("Heart Queen", $card->getAsString());

        $card->assignValue(13);
        $this->assertEquals("Heart King", $card->getAsString());

        $card->assignValue(14);
        $this->assertEquals("Heart Ace", $card->getAsString());
    }
}
