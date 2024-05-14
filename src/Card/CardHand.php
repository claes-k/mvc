<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    protected $hand = [];

    public function addCard($card): void
    {
        $this->hand[] = $card;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    public function getHand(): array
    {
        return $this->hand;
    }
}
