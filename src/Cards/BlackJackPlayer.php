<?php

namespace App\Cards;

use App\Cards\CardHand;
use App\Cards\CardGraphic;
use App\Cards\BlackJackUtility;

class BlackJackPlayer
{
    private BlackJackUtility $utility;
    private CardHand $hand;
    public int $score;
    private int $bet;
    public bool $isStanding;
    public bool $isBust;

    /**
     * BlackJackPlayer constructor.
     */
    public function __construct()
    {
        $this->hand = new CardHand();
        $this->score = 0;
        $this->bet = 0;
        $this->isStanding = false;
        $this->isBust = false;
        $this->utility = new BlackJackUtility();
    }

    /**
     * @return CardHand
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
     * @return CardGraphic[]
     */
    public function getCards(): array
    {
        return $this->hand->getCards();
    }

    /**
     * @param CardGraphic $card
     * @return void
     */
    public function addCard(CardGraphic $card): void
    {
        $this->hand->addCard($card);
        $this->updateScore();
        if ($this->getScore() === 21) {
            $this->setStanding(true);
        } elseif ($this->getScore() > 21) {
            $this->setBust(true);
        }
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @return void
     */
    public function clearHand(): void
    {
        $this->hand = new CardHand();
    }

    /**
     * @param int $score
     * @return void
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getBet(): int
    {
        return $this->bet;
    }

    /**
     * @param int $bet
     * @return void
     */
    public function setBet(int $bet): void
    {
        $this->bet = $bet;
    }

    /**
     * @return bool
     */
    public function isBust(): bool
    {
        return $this->isBust;
    }

    /**
     * @param bool $isBust
     * @return void
     */
    public function setBust(bool $isBust): void
    {
        $this->isBust = $isBust;
    }

    /**
     * @param bool $isStanding
     * @return void
     */
    public function setStanding(bool $isStanding): void
    {
        $this->isStanding = $isStanding;
    }

    /**
     * @return bool
     */
    public function isStanding(): bool
    {
        return $this->isStanding;
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->hand = new CardHand();
        $this->score = 0;
        $this->bet = 0;
        $this->isStanding = false;
        $this->isBust = false;
    }

    /**
     * Updates the score of the player
     * @return void
     */
    private function updateScore(): void
    {
        $score = $this->utility->countScore($this->getHand());
        $this->setScore($score);
        if ($score > 21) {
            $this->setBust(true);
        }
        if ($score === 21) {
            $this->setStanding(true);
        }
    }
}
