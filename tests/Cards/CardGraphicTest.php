<?php

namespace App\Tests\Cards;

use PHPUnit\Framework\TestCase;
use App\Cards\CardGraphic;

class CardGraphicTest extends TestCase
{
    public function testInitialValues(): void
    {
        $card = new CardGraphic();
        $this->assertEquals("", $card->getSuit());
        $this->assertEquals(0, $card->getValue());
    }

    public function testAssignValue(): void
    {
        $card = new CardGraphic();
        $card->assignValue(10);
        $this->assertEquals(10, $card->getValue());
    }

    public function testAssignSuit(): void
    {
        $card = new CardGraphic();
        $card->assignSuit("heart");
        $this->assertEquals("heart", $card->getSuit());
    }

    public function testGetAsCard(): void
    {
        $card = new CardGraphic();
        $card->assignSuit("heart");
        $card->assignValue(10);
        $this->assertEquals("🂺", $card->getAsCard());

        $card->assignValue(11);
        $this->assertEquals("🂻", $card->getAsCard());

        $card->assignValue(12);
        $this->assertEquals("🂽", $card->getAsCard());

        $card->assignValue(13);
        $this->assertEquals("🂾", $card->getAsCard());

        $card->assignValue(14);
        $this->assertEquals("🂱", $card->getAsCard());
    }

    public function testToString(): void
    {
        $card = new CardGraphic();
        $card->assignSuit("spade");
        $card->assignValue(1);
        $this->assertEquals("🂡", (string)$card);
    }
}
