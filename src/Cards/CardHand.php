<?php

namespace App\Cards;

class CardHand
{
    /**
     * @var CardGraphic[]
     */
    protected $cards;

    public function __construct()
    {
        $this->cards = [];
    }

    public function addCard(CardGraphic $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * @return CardGraphic[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function cardCount(): int
    {
        return count($this->cards);
    }
}
