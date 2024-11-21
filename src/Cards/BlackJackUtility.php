<?php

namespace App\Cards;

class BlackJackUtility
{
    public function countScore(CardHand $hand): int
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
}