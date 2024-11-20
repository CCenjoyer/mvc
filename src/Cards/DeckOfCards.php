<?php

namespace App\Cards;

use Exception;

class DeckOfCards
{
    /**
     * @var CardGraphic[]
     */
    protected $cards;

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
     * Makes a deck of cards
     * @return void
     */
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


    /**
     * Shuffles the deck
     * @return void
     */
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * Draws a card from the deck
     * @return CardGraphic
     * @throws Exception
     */
    public function drawCard(): CardGraphic
    {
        $card = array_shift($this->cards);
        if ($card === null) {
            throw new Exception("No cards left in the deck");
        }
        return $card;
    }


    /**
     * Gets the number of cards in the deck
     * @return int
     */
    public function cardCount(): int
    {
        return count($this->cards);
    }

    /**
     * Sorts the deck
     * @return void
     */
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
