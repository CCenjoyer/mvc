<?php

namespace App\Cards;

class CardGraphic extends Card
{
    private $representation = [
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

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsCard()
    {
        return $this->representation[$this->suit][$this->value];
    }

    public function __toString() {
        return $this->getAsCard();
    }
}
