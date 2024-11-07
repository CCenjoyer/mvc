<?php

namespace App\Cards;

class GameTwentyOne
{
    private DeckOfCards $deck;
    private CardHand $playerHand;
    private CardHand $dealerHand;
    private int $playerScore;
    private int $dealerScore;

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

    public function drawPlayerCard(): void
    {
        $card = $this->deck->drawCard();
        $this->playerHand->addCard($card);
        $this->updateScores();
    }

    public function drawDealerCard(): void
    {
        $card = $this->deck->drawCard();
        $this->dealerHand->addCard($card);
        $this->updateScores();
    }

    private function updateScores(): void
    {
        $this->playerScore = $this->calculateScore($this->playerHand);
        $this->dealerScore = $this->calculateScore($this->dealerHand);
    }

    private function calculateScore(CardHand $hand): int
    {
        $score = 0;
        $aces = 0;

        foreach ($hand->getCards() as $card) {
            $value = $card->getValue();
            if ($value >= 11 && $value <= 13) {
                $score += 10;
            } elseif ($value == 14) {
                $aces++;
                $score += 11;
            } else {
                $score += $value;
            }
        }

        while ($score > 21 && $aces > 0) {
            $score -= 10;
            $aces--;
        }

        return $score;
    }

    public function getPlayerScore(): int
    {
        return $this->playerScore;
    }

    public function getDealerScore(): int
    {
        return $this->dealerScore;
    }

    public function getPlayerHand(): array
    {
        return $this->playerHand->getCards();
    }

    public function getDealerHand(): array
    {
        return $this->dealerHand->getCards();
    }

    public function getDeckCount(): int
    {
        return $this->deck->cardCount();
    }

    public function isGameOver(): bool
    {
        return $this->playerScore >= 21 || $this->dealerScore >= 21;
    }

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
        } else {
            return "Dealer wins!";
        }
    }
}