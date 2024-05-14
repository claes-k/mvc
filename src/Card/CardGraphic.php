<?php

namespace App\Card;

class CardGraphic extends Card
{
    protected $graphic;

    public function __construct($suitInput, $valueInput, $graphicInput)
    {
        parent::__construct($suitInput, $valueInput);

        $this->graphic = $graphicInput;
    }

    public function getAsString(): string
    {
        return $this->graphic;
    }
}
