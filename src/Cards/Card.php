<?php

namespace App\Cards;

class Card
{
    protected ?string $suit;
    protected ?int $value;

    public function __construct()
    {
        $this->suit = null;
        $this->value = null;
    }


    public function assignValue(int $value): void
    {
        $this->value = $value;
    }

    public function assignSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function getSuit(): ?string
    {
        return $this->suit;
    }

    public function getAsString(): string
    {
        return "[{$this->suit} {$this->value}]";
    }
}
