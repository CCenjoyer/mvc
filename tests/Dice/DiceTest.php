<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify it it a Dice object.
     */
    public function testCreateObject(): void
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getValue();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    /**
     * Roll the dice and assert value is within bounds.
     */
    public function testRollDice(): void
    {
        $die = new Dice();
        $res = $die->roll();
        $this->assertIsInt($res);

        $res = $die->getValue();
        $this->assertTrue($res >= 1);
        $this->assertTrue($res <= 6);
    }

    /**
     * Get the value of the dice as a string.
     */
    public function testGetAsString(): void
    {
        $dice = new Dice();
        $dice->roll();
        $value = $dice->getValue();
        $this->assertEquals("[{$value}]", $dice->getAsString());
    }
}
