<?php

namespace App\Card;

class CardGraphic extends Card
{
    protected $graphic;
    // private $spades = [
    //     'https://upload.wikimedia.org/wikipedia/commons/5/5a/Ace_of_spades.svg',
    //     '♠2',
    //     '♠3',
    //     '♠4',
    //     '♠5',
    //     '♠6',
    //     '♠7',
    //     '♠8',
    //     'https://upload.wikimedia.org/wikipedia/commons/6/63/9_of_spades.svg',
    //     '♠10',
    //     'https://upload.wikimedia.org/wikipedia/commons/a/a9/Jack_of_spades2.svg',
    //     '♠Q',
    //     '♠K',
    // ];

    // ♥
    // ♦
    // ♣

    public function __construct($suitInput, $valueInput, $graphicInput)
    {
        parent::__construct($suitInput, $valueInput);

        $this->graphic = $graphicInput;
    }

    public function getAsString(): string
    {
        // if ($this->suit == "1" || $this->suit == "♠" || $this->suit == "Spades") {
        //     return $this->spades[$this->value - 1];
        //     return "{$this->value} of {$this->suit}";
        // }
        return $this->graphic;
    }
}
