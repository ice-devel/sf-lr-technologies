<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig', name: 'twig')]
    public function index(): Response
    {
        $chaine = "Bonjour";
        $entier = rand(1,20);
        $booleen = true;
        $cities = ['Lille', 'Paris', 'Toulouse'];

        $topic1 = [
            'title' => "PHP TOP MAIS..",
            'desc' => 'Mon projet en PHP il merde quand je fais blabla'
        ];
        $fct = function() {
            return "salut";
        };

        return $this->render('app/index.html.twig', [
            'chaine' => $chaine,
            'entierTwig' => $entier,
            'booleen' => $booleen,
            'topic1' => $topic1,
            'fct' => $fct,
            'cities' => $cities
        ]);
    }
}
