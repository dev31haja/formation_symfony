<?php

namespace App\Service;

class Calculator {
    private $selector;
    
    public function __construct(TvaSelector $tva)
    {
        $this->selector = $tva;
    }

    public function calculTva(float $price): float {
        dump('price = '.$price);

        return $price * $this->selector->getTva();
    }
}