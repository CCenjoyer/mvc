<?php

namespace App\Cards;

use App\Cards\DeckOfCards;
use App\Cards\CardHand;
use App\Cards\BlackJackPlayer;
use App\Cards\CardGraphic;
use App\Cards\BlackJackUtility;

class BlackJack
{
    /**
     * @var BlackJackPlayer[]
     * */
    public array $players;
    private DeckOfCards $deck;
    private BlackJackUtility $utility;
    public CardHand $dealerHand;
    public int $playerCount;
    public int $dealerScore;
    public bool $dealerTurn = false;
    public int $currentPlayerIndex;
    public int $startingMoney;
    public float $money;

    public function __construct(int $peoplePlaying = 1, int $startingMoney = 100)
    {
        $this->dealerHand = new CardHand();
        $this->utility = new BlackJackUtility();
        $this->deck = new DeckOfCards();
        $this->deck->makeDeck();
        $this->deck->shuffle();

        $this->currentPlayerIndex = 0;
        $this->dealerScore = 0;
        $this->startingMoney = $startingMoney;
        $this->money = $startingMoney;
        $this->playerCount = $peoplePlaying;

        for ($i = 0; $i < $peoplePlaying; $i++) {
            $this->players[] = new BlackJackPlayer();
        }
    }

    /**
     * @param int $playerIndex
     * @param int $amount
     * @return void
     */
    public function placeBet(int $playerIndex, int $amount): void
    {
        $player = $this->players[$playerIndex];
        $player->setBet($amount);
        $this->money = $this->money - $amount;
    }

    /**
     * Deals two cards to each player and the dealer
     * @return void
     */
    public function dealInitialCards(): void
    {
        foreach ($this->players as $player) {
            $player->addCard($this->deck->drawCard());
            $player->addCard($this->deck->drawCard());
        }
        $this->dealerHand->addCard($this->deck->drawCard());
        $this->dealerHand->addCard($this->deck->drawCard());
        $this->updateDealerScore();
    }

    /**
     * Checks if all players are standing or bust
     * @return bool
     */
    public function checkPlayersTurnsOver(): bool
    {
        foreach ($this->players as $player) {
            if (!$player->isStanding() && !$player->isBust()) {
                return false;
            }
        }
        $this->dealerTurn = true;
        return true;
    }

    /**
     * @return void
     */
    public function nextTurn(): void
    {
        $this->currentPlayerIndex++;
        if ($this->currentPlayerIndex >= $this->playerCount) {
            $this->currentPlayerIndex = 0;
        }
        $allPlayersDone = true;
        foreach ($this->players as $player) {
            if (!$player->isStanding() && !$player->isBust()) {
                $allPlayersDone = false;
                break;
            }
        }
        if ($allPlayersDone) {
            $this->dealerTurn = true;
        }
    }

    /**
     * Calculates the outcome of the round and resets the game
     * @return void
     */
    public function nextRound(): void
    {
        $newMoney = $this->money;
        $dealerScore = $this->dealerScore;

        foreach ($this->players as $player) {
            $score = $player->getScore();
            if ($score === 21 && $dealerScore !== 21) {
                $newMoney += $player->getBet() * 2.5;
            } elseif ($dealerScore > 21 && $score < 22) {
                $newMoney += $player->getBet() * 2;
            } elseif ($score === $dealerScore) {
                $newMoney += $player->getBet();
            } elseif ($score < 22 && $score > $dealerScore) {
                $newMoney += $player->getBet() * 2;
            }
            $player->reset();
        }

        $this->money = $newMoney;

        $this->currentPlayerIndex = 0;
        $this->dealerHand = new CardHand();
        $this->dealerScore = 0;
        $this->deck->makeDeck();
        $this->deck->shuffle();
        $this->dealerTurn = false;
        $this->dealInitialCards();
    }

    /**
     * Draws a card from the deck and adds it to the current player's hand
     * @return void
     */
    public function hit(): void
    {
        $player = $this->players[$this->currentPlayerIndex];
        $player->addCard($this->deck->drawCard());
        if ($player->getScore() > 21 || $player->isStanding) {
            $this->nextTurn();
        }
    }

    /**
     * Ends the current player's turn
     * @return void
     */
    public function stand(): void
    {
        $player = $this->players[$this->currentPlayerIndex];
        $player->isStanding = true;
        $this->nextTurn();
    }

    /**
     * Updates the score of the dealer
     * @return void
     */
    public function dealerDraw(): void
    {
        while ($this->dealerScore < 17) {
            $this->dealerHand->addCard($this->deck->drawCard());
            $this->updateDealerScore();
        }
    }

    /**
     * Updates the score of the dealer
     * @return void
     */
    public function updateDealerScore(): void
    {
        $this->dealerScore = $this->utility->countScore($this->dealerHand);
    }

    /**
     * Checks if the game is over
     * @return bool
     */
    public function isGameOver(): bool
    {
        return $this->money <= 0;
    }
}
