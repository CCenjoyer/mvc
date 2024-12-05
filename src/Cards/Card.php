<?php

namespace App\Cards;

/**
 * Class Card
 * @package App\Cards
 */
class Card
{
    protected string $suit;
    protected int $value;

    /**
     * Constructor
     * @param string $suit
     * @param int $value
     */
    public function __construct($suit = "", $value = 0)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    /**
     * Assigns a value to the card
     *
     * @param int $value
     * @example 14
     */
    public function assignValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * Assigns a suit to the card
     *
     * @param string $suit
     * @example "Spades"
     */
    public function assignSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    /**
     * Returns the value of the card
     *
     * @return int
     * @example 14
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Returns the suit of the card
     *
     * @return string
     * @example "Spades"
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Returns the card as a string
     *
     * @return string
     * @example "Spades Ace"
     */
    public function getAsString(): string
    {
        $value = $this->value;
        switch ($value) {
            case 11:
                $valueStr = 'Jack';
                break;
            case 12:
                $valueStr = 'Queen';
                break;
            case 13:
                $valueStr = 'King';
                break;
            case 14:
                $valueStr = 'Ace';
                break;
            default:
                $valueStr = (string)$value;
                break;
        }

        return "{$this->suit} {$valueStr}";
    }
}
