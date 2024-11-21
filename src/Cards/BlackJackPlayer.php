<?php

namespace App\Cards;

use App\Cards\CardHand;
use App\Cards\CardGraphic;

class BlackJackPlayer
{
    private CardHand $hand;
    private int $score;
    private int $bet;
    private bool $isStanding;
    private bool $isBust;
    private bool $isBlackJack;

    public function __construct()
    {
        $this->hand = new CardHand();
        $this->score = 0;
        $this->bet = 0;
        $this->isStanding = false;
        $this->isBust = false;
    }

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

    public function isBlackJack(): bool
    {
        return $this->isBlackJack;
    }

    public function setBlackJack(bool $isBlackJack): void
    {
        $this->isBlackJack = $isBlackJack;
    }

    /**
     * @param CardGraphic $card
     * @return void
     */
    public function addCard(CardGraphic $card): void
    {
        $this->hand->addCard($card);
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function clearHand(): void
    {
        $this->hand = new CardHand();
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getBet(): int
    {
        return $this->bet;
    }

    public function setBet(int $bet): void
    {
        $this->bet = $bet;
    }

    public function isBust(): bool
    {
        return $this->isBust;
    }

    public function setBust(bool $isBust): void
    {
        $this->isBust = $isBust;
    }

    public function setStanding(bool $isStanding): void
    {
        $this->isStanding = $isStanding;
    }

    public function isStanding(): bool
    {
        return $this->isStanding;
    }

    public function reset(): void
    {
        $this->hand = new CardHand();
        $this->score = 0;
        $this->bet = 0;
        $this->isStanding = false;
        $this->isBust = false;
    }
}
