<?php

namespace App\Cards;

class DeckOfCards
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

    public function getCards(): array
    {
        return $this->cards;
    }

    public function makeDeck(): void
    {
        $this->cards = [];
        $suits = ['diamond', 'heart', 'club', 'spade'];
        foreach ($suits as $suit) {
            for ($value = 2; $value <= 14; $value++) {
                $card = new CardGraphic();
                $card->assignSuit($suit);
                $card->assignValue($value);
                $this->addCard($card);
            }
        }
    }
}
