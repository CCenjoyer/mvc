<?php

namespace App\Cards;

class CardHand
{
    protected $cards;

    public function __construct()
    {
        $this->cards = [];
    }

    public function addCard(CardGraphic $card): void
    {
        $this->cards[] = $card;
    }

    public function getCards(): ?array
    {
        return $this->cards;
    }
}
