<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;

class CardDeck
{
    protected $deck = [];

    public function __construct()
    {
        $suits = ["Spades", "Hearts", "Diamonds", "Clubs"];
        $values = ["Ace", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Jack", "Queen", "King"];
        $graphics =
            [
                "Spades" => [
                    "Spades-Ace.svg",
                    "Spades-2.svg",
                    "Spades-3.svg",
                    "Spades-4.svg",
                    "Spades-5.svg",
                    "Spades-6.svg",
                    "Spades-7.svg",
                    "Spades-8.svg",
                    "Spades-9.svg",
                    "Spades-10.svg",
                    "Spades-Jack.svg",
                    "Spades-Queen.svg",
                    "Spades-King.svg"
                ],
                "Hearts" => [
                    "Hearts-Ace.svg",
                    "Hearts-2.svg",
                    "Hearts-3.svg",
                    "Hearts-4.svg",
                    "Hearts-5.svg",
                    "Hearts-6.svg",
                    "Hearts-7.svg",
                    "Hearts-8.svg",
                    "Hearts-9.svg",
                    "Hearts-10.svg",
                    "Hearts-Jack.svg",
                    "Hearts-Queen.svg",
                    "Hearts-King.svg"
                ],
                "Diamonds" => [
                    "Diamonds-Ace.svg",
                    "Diamonds-2.svg",
                    "Diamonds-3.svg",
                    "Diamonds-4.svg",
                    "Diamonds-5.svg",
                    "Diamonds-6.svg",
                    "Diamonds-7.svg",
                    "Diamonds-8.svg",
                    "Diamonds-9.svg",
                    "Diamonds-10.svg",
                    "Diamonds-Jack.svg",
                    "Diamonds-Queen.svg",
                    "Diamonds-King.svg"
                ],
                "Clubs" => [
                    "Clubs-Ace.svg",
                    "Clubs-2.svg",
                    "Clubs-3.svg",
                    "Clubs-4.svg",
                    "Clubs-5.svg",
                    "Clubs-6.svg",
                    "Clubs-7.svg",
                    "Clubs-8.svg",
                    "Clubs-9.svg",
                    "Clubs-10.svg",
                    "Clubs-Jack.svg",
                    "Clubs-Queen.svg",
                    "Clubs-King.svg"
                ],
            ];

        foreach ($suits as $suit) {
            foreach ($values as $index => $value) {
                $graphic = $graphics[$suit][$index];
                $this->deck[] = new CardGraphic($suit, $value, $graphic);
            }
        }
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    public function shuffleCards(): array
    {
        shuffle($this->deck);
        return $this->deck;
    }

    public function getDeck(): array
    {
        return $this->deck;
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    public function drawCard(): object
    {
        $card = $this->deck[0];
        unset($this->deck[0]);
        return $card;
    }
}
