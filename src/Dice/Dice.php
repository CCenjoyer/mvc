<?php

namespace App\Dice;

class Dice
{
    protected ?int $value;

    /**
     * Constructor to initiate the dice with six sides.
     */
    public function __construct()
    {
        $this->value = null;
    }

    /**
     * Roll the dice and set the value.
     *
     * @return int as the value of the dice.
     */
    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    /**
     * Get the value of the dice.
     *
     * @return int as the value of the dice.
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Get the dice as a string.
     *
     * @return string as the dice as a string.
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
