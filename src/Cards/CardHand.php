<?php

namespace App\Cards;

class CardHand
{
    /**
     * @var CardGraphic[]
     */
    protected $cards;

    /**
     * CardHand constructor.
     */
    public function __construct()
    {
        $this->cards = [];
    }


    /**
     * @param CardGraphic $card
     * @return void
     */
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

    /**
     * @return int
     */
    public function cardCount(): int
    {
        return count($this->cards);
    }
}
