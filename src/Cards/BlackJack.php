<?php

namespace App\Cards;

use App\Cards\DeckOfCards;
use App\Cards\CardHand;
use App\Cards\BlackJackPlayer;
use App\Cards\CardGraphic;
use App\Cards\BlackJackUtility;
use phpDocumentor\Reflection\PseudoTypes\True_;

class BlackJack
{
    /**
     * @var BlackJackPlayer[]
     * */
    private array $players;
    private DeckOfCards $deck;
    private BlackJackUtility $utility;
    private CardHand $dealerHand;
    private int $playerCount;
    public int $dealerScore;
    private int $currentTurn;
    private int $currentPlayerIndex;
    private int $startingMoney;
    private int $money;
    public string $cardBack = '🂠';

    public function __construct(int $peoplePlaying = 1, int $startingMoney = 100)
    {
        $this->deck = new DeckOfCards();
        $this->deck->makeDeck();
        $this->deck->shuffle();

        $this->startingMoney = $startingMoney;
        $this->money = $startingMoney;
        $this->playerCount = $peoplePlaying;
        $this->currentPlayerIndex = 0;
        $this->currentTurn = 0;

        for ($i = 0; $i < $peoplePlaying; $i++) {
            $this->players[] = new BlackJackPlayer();
        }

        $this->dealerHand = new CardHand();
        $this->dealerScore = 0;
        $this->utility = new BlackJackUtility();
    }

    public function getCurrentPlayerIndex(): int
    {
        return $this->currentPlayerIndex;
    }

    public function getCurrentPlayer(): BlackJackPlayer
    {
        return $this->players[$this->getCurrentPlayerIndex()];
    }

    /**
     * @return CardGraphic[]
     */
    public function getDealerCards(): array
    {
        return $this->dealerHand->getCards();
    }

    public function getPlayerCount(): int
    {
        return $this->playerCount;
    }

    public function placeBet(int $playerIndex, int $amount): void
    {
        $player = $this->players[$playerIndex];
        $player->setBet($amount);
        $this->money = $this->money - $amount;
    }

    /**
     * @return BlackJackPlayer[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getDealer(): CardHand
    {
        return $this->dealerHand;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function getStartingMoney(): int
    {
        return $this->startingMoney;
    }

    public function updateDealerScore(): void
    {
        $this->dealerScore = $this->utility->countScore($this->dealerHand);
    }

    public function dealInitialCards(): void
    {

        foreach ($this->players as $player) {
            $score = 0;
            $player->addCard($this->deck->drawCard());
            $player->addCard($this->deck->drawCard());
            $score = $this->utility->countScore($player->getHand());
            $player->setScore($score);
        }

        $this->dealerHand->addCard($this->deck->drawCard());
        $this->dealerHand->addCard($this->deck->drawCard());
        $this->updateDealerScore();
    }

    public function checkPlayersTurnsOver(): bool
    {
        $done = false;
        foreach ($this->players as $player) {
            // if ($player->isStanding() || $player->isBust() || $player->getBet() === 0)
            if ($player->isStanding() || $player->isBust()) {
                $done = true;
                ;
            }
        }
        return $done;
    }

    /**
     * @return CardGraphic[]
     */
    public function getPlayerCards(int $handIndex): array
    {
        return $this->players[$handIndex]->getCards();
    }

    public function nextTurn(): void
    {
        $currentPlayerIndex = $this->currentPlayerIndex;

        $this->currentPlayerIndex++;
        if ($currentPlayerIndex >= $this->playerCount - 1) {
            $this->currentPlayerIndex = 0;
            $this->currentTurn++;
        }
    }

    public function nextRound(): void
    {
        $this->currentPlayerIndex = 0;
        $this->currentTurn = 0;
        $this->dealerHand = new CardHand();
        $this->dealerScore = 0;
        $this->deck->makeDeck();
        $this->deck->shuffle();

        foreach ($this->players as $player) {
            $player->reset();
        }
    }

    public function hit(): void
    {
        $player = $this->getCurrentPlayer();
        $player->addCard($this->deck->drawCard());

        $this->updateScore($player);
    }

    public function stand(): void
    {
        $this->nextTurn();
    }

    public function updateScore(BlackJackPlayer $player): void
    {
        $score = $this->utility->countScore($player->getHand());
        $player->setScore($score);
        if ($score > 21) {
            $player->setBust(true);
            $this->nextTurn();
        }
        if ($score === 21) {
            $player->setBlackjack(true);
            $this->nextTurn();
        }
    }

    public function isGameOver(): bool
    {
        if ($this->getMoney() <= 0) {
            return true;
        }
        return false;
    }
}
