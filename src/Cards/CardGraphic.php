<?php

namespace App\Cards;

/**
 * Class CardGraphic
 * @package App\Cards
 */
class CardGraphic extends Card
{
    /**
     * @var array<string, array<int, string>>
     */
    private array $representation = [
        'diamond' => [
            1 => '🃁', 2 => '🃂', 3 => '🃃', 4 => '🃄', 5 => '🃅',
            6 => '🃆', 7 => '🃇', 8 => '🃈', 9 => '🃉', 10 => '🃊',
            11 => '🃋', 12 => '🃍', 13 => '🃎', 14 => '🃁'
        ],
        'heart' => [
            1 => '🂱', 2 => '🂲', 3 => '🂳', 4 => '🂴', 5 => '🂵',
            6 => '🂶', 7 => '🂷', 8 => '🂸', 9 => '🂹', 10 => '🂺',
            11 => '🂻', 12 => '🂽', 13 => '🂾', 14 => '🂱'
        ],
        'club' => [
            1 => '🃑', 2 => '🃒', 3 => '🃓', 4 => '🃔', 5 => '🃕',
            6 => '🃖', 7 => '🃗', 8 => '🃘', 9 => '🃙', 10 => '🃚',
            11 => '🃛', 12 => '🃝', 13 => '🃞', 14 => '🃑'
        ],
        'spade' => [
            1 => '🂡', 2 => '🂢', 3 => '🂣', 4 => '🂤', 5 => '🂥',
            6 => '🂦', 7 => '🂧', 8 => '🂨', 9 => '🂩', 10 => '🂪',
            11 => '🂫', 12 => '🂭', 13 => '🂮', 14 => '🂡'
        ],
    ];

    /**
     * CardGraphic constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the card as a string
     *
     * @return string
     */
    public function getAsCard(): string
    {
        return $this->representation[$this->suit][$this->value];
    }

    /**
     * Returns the card as a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getAsCard();
    }
}
