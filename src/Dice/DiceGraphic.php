<?php

namespace App\Dice;

class DiceGraphic extends Dice
{
    /**
     * @var string[]
     */
    private $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    /**
     * Constructor to initiate the dice with six sides.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the dice as a string.
     *
     * @return string as the dice as a string.
     */
    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
