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

    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
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
