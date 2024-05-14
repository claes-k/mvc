<?php

namespace App\Card;

class Card
{
    protected $suit;
    protected $value;

    public function __construct($suitInput, $valueInput)
    {
        $this->suit = $suitInput;
        $this->value = $valueInput;
    }

    public function getAsString(): string
    {
        // return "[{$this->suit}{$this->value}]";
        return "{$this->value} of {$this->suit}";
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
