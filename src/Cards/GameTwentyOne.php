<?php

namespace App\Cards;

/**
 * Class GameTwentyOne
 * Class to handle the game of Twenty-One (Blackjack)
 */
class GameTwentyOne
{
    private DeckOfCards $deck;
    private CardHand $playerHand;
    private CardHand $dealerHand;
    private int $playerScore;
    private int $dealerScore;

    /**
     * Constructor to create a new game of Twenty-One
     */
    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->deck->makeDeck();
        $this->deck->shuffle();
        $this->playerHand = new CardHand();
        $this->dealerHand = new CardHand();
        $this->playerScore = 0;
        $this->dealerScore = 0;
    }

    /**
     * Draw a card for the player
     * @return void
     */
    public function drawPlayerCard(): void
    {
        $card = $this->deck->drawCard();
        $this->playerHand->addCard($card);
        $this->updateScores();
    }

    /**
     * Draw a card for the dealer
     * @return void
     */
    public function drawDealerCard(): void
    {
        $card = $this->deck->drawCard();
        $this->dealerHand->addCard($card);
        $this->updateScores();
    }
    
    /**
     * Draw two cards for the player
     * @return void
     */
    private function updateScores(): void
    {
        $this->playerScore = $this->calculateScore($this->playerHand);
        $this->dealerScore = $this->calculateScore($this->dealerHand);
    }

    /**
     * Calculate the score of a hand
     * @param CardHand $hand
     * @return int
     */
    private function calculateScore(CardHand $hand): int
    {
        $score = 0;
        $aces = 0;
        foreach ($hand->getCards() as $card) {
            $value = $card->getValue();
            if ($value >= 11 && $value <= 13) {
                $score += 10;
                continue;
            }
            if ($value == 14) {
                $aces++;
                $score += 11;
                continue;
            }
            $score += $value;
        }
        while ($score > 21 && $aces > 0) {
            $score -= 10;
            $aces--;
        }
        return $score;
    }

    /**
     * Get the score of the player
     * @return int
     */
    public function getPlayerScore(): int
    {
        return $this->playerScore;
    }

    /**
     * Get the score of the dealer
     * @return int
     */
    public function getDealerScore(): int
    {
        return $this->dealerScore;
    }

    /**
     * Get the player's hand
     * @return Card[]
     */
    public function getPlayerHand(): array
    {
        return $this->playerHand->getCards();
    }

    /**
     * Get the dealer's hand
     * @return Card[]
     */
    public function getDealerHand(): array
    {
        return $this->dealerHand->getCards();
    }

    /**
     * Get the number of cards left in the deck
     * @return int
     */
    public function getDeckCount(): int
    {
        return $this->deck->cardCount();
    }

    /**
     * Check if the game is over
     * @return bool
     */
    public function isGameOver(): bool
    {
        return $this->playerScore >= 21 || $this->dealerScore >= 17;
    }

    /**
     * Determine the winner of the game
     * @return string
     */
    public function determineWinner(): string
    {
        if ($this->playerScore > 21) {
            return 'Dealer wins!';
        } elseif ($this->dealerScore > 21) {
            return 'Player wins!';
        } elseif ($this->playerScore > $this->dealerScore) {
            return 'Player wins!';
        } elseif ($this->dealerScore > $this->playerScore) {
            return 'Dealer wins!';
        }
        return "Dealer wins!";
    }
}
