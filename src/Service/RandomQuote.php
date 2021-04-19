<?php
namespace App\Service;

class RandomQuote
{
    public function getRandomQuote()
    {
        $quotes = [
            'Le lundi c\'est dur',
            'Le vendredi pas de mise en prod',
        ];

        return $quotes[rand(0,1)];
    }


}