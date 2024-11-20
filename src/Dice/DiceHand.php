<?php

namespace App\Dice;

use App\Dice\Dice;

/**
 * Class DiceHand
 * @package App\Dice
 */
class DiceHand
{
    /**
     * @var Dice[]
     */
    private array $hand = [];

    /**
     * Constructor
     */
    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    /**
     * Roll all dices in the hand
     * @return void
     */
    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    /**
     * Get the sum of all dices in the hand
     * @return int as the sum of all dices in the hand
     */
    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
     * At an array of integers with the values of the dices
     * @return int[]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $value = $die->getValue();
            if ($value !== null) {
                $values[] = $value;
            }
        }
        return $values;
    }

    /**
     * Get an array of strings with the values of the dices
     * @return string[]
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
