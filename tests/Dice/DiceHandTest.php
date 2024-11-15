<?php

namespace App\Tests\Dice;

use PHPUnit\Framework\TestCase;
use App\Dice\Dice;
use App\Dice\DiceHand;

class DiceHandTest extends TestCase
{
    public function testAddDice(): void
    {
        $hand = new DiceHand();
        $dice = new Dice();
        $hand->add($dice);
        $this->assertEquals(1, $hand->getNumberDices());
    }

    public function testRoll(): void
    {
        $hand = new DiceHand();
        $dice1 = new Dice();
        $dice2 = new Dice();
        $hand->add($dice1);
        $hand->add($dice2);
        $hand->roll();

        $values = $hand->getValues();
        $this->assertCount(2, $values);
        foreach ($values as $value) {
            $this->assertGreaterThanOrEqual(1, $value);
            $this->assertLessThanOrEqual(6, $value);
        }
    }

    public function testGetNumberDices(): void
    {
        $hand = new DiceHand();
        $this->assertEquals(0, $hand->getNumberDices());

        $dice = new Dice();
        $hand->add($dice);
        $this->assertEquals(1, $hand->getNumberDices());
    }

    public function testGetValues(): void
    {
        $hand = new DiceHand();
        $dice1 = new Dice();
        $dice2 = new Dice();
        $hand->add($dice1);
        $hand->add($dice2);
        $hand->roll();

        $values = $hand->getValues();
        $this->assertCount(2, $values);
        foreach ($values as $value) {
            $this->assertGreaterThanOrEqual(1, $value);
            $this->assertLessThanOrEqual(6, $value);
        }
    }

    public function testGetString(): void
    {
        $hand = new DiceHand();
        $dice1 = new Dice();
        $dice2 = new Dice();
        $hand->add($dice1);
        $hand->add($dice2);
        $hand->roll();

        $strings = $hand->getString();
        $this->assertCount(2, $strings);
        $expectedValues = ['[1]', '[2]', '[3]', '[4]', '[5]', '[6]'];
        foreach ($strings as $string) {
            $this->assertContains($string, $expectedValues);
        }
    }
}
