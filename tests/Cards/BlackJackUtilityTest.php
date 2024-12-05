<?php

namespace App\Tests\Cards;

use App\Cards\BlackJackUtility;
use App\Cards\CardGraphic;
use App\Cards\CardHand;
use PHPUnit\Framework\TestCase;

class BlackJackUtilityTest extends TestCase
{
    public function testCountScore(): void
    {
        $utility = new BlackJackUtility();
        $hand = new CardHand();

        $hand->addCard(new CardGraphic('heart', 2));
        $hand->addCard(new CardGraphic('diamond', 11));
        $hand->addCard(new CardGraphic('club', 14));

        $score = $utility->countScore($hand);
        $this->assertEquals(13, $score);

        $hand = new CardHand();
        $hand->addCard(new CardGraphic('heart', 14));
        $hand->addCard(new CardGraphic('diamond', 14));
        $hand->addCard(new CardGraphic('club', 9));

        $score = $utility->countScore($hand);
        $this->assertEquals(21, $score);
    }
}
