<?php

namespace App\Tests\Dice;

use PHPUnit\Framework\TestCase;
use App\Dice\DiceGraphic;

class DiceGraphicTest extends TestCase
{
    public function testInitialValueIsNull(): void
    {
        $dice = new DiceGraphic();
        $this->assertNull($dice->getValue());
    }

    public function testRollReturnsValueBetween1And6(): void
    {
        $dice = new DiceGraphic();
        $value = $dice->roll();
        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(6, $value);
    }

    public function testGetValueAfterRoll(): void
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $value = $dice->getValue();
        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(6, $value);
    }

    public function testGetAsString(): void
    {
        $dice = new DiceGraphic();
        $dice->roll();
        $value = $dice->getValue();
        $representation = [
            '⚀',
            '⚁',
            '⚂',
            '⚃',
            '⚄',
            '⚅',
        ];
        $this->assertEquals($representation[$value - 1], $dice->getAsString());
    }
}
