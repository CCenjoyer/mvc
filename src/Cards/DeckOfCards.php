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

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function drawCard(): ?CardGraphic
    {
        if (empty($this->cards)) {
            return null;
        }
        return array_shift($this->cards);
    }

    public function cardCount(): int
    {
        return count($this->cards);
    }

    public function sort(): void
    {
        $sortedCards = [];
        $suits = ['diamond', 'heart', 'club', 'spade'];
        foreach ($suits as $suit) {
            for ($value = 2; $value <= 14; $value++) {
                foreach ($this->cards as $card) {
                    if ($card->getSuit() === $suit && $card->getValue() === $value) {
                        $sortedCards[] = $card;
                    }
                }
            }
        }
        $this->cards = $sortedCards;
    }
}
