<?php

namespace App\Cards;

class Card
{
    protected string $suit;
    protected int $value;

    public function __construct()
    {
        $this->suit = "";
        $this->value = 0;
    }


    public function assignValue(int $value): void
    {
        $this->value = $value;
    }

    public function assignSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

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
