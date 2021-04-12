<?php

namespace App\Twig;

use App\Service\RandomQuote;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UtilExtension extends AbstractExtension
{
    protected $randomQuote;

    public function __construct(RandomQuote $randomQuote) {
        $this->randomQuote = $randomQuote;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('random_quote', [$this, 'getRandomQuote']),
        ];
    }

    public function getRandomQuote()
    {
       return $this->randomQuote->getRandomQuote();
    }
}
