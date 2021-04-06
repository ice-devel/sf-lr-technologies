<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(): Response
    {
        //return new Response("contenu");

        return $this->render('app/index.html.twig');
    }

    #[Route('/test', name: 'test')]
    public function test(): Response
    {
        return new Response("page test");
    }
}
