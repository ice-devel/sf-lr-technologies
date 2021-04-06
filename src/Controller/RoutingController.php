<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoutingController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(): Response
    {
        //return new Response("contenu");

        return new Response("page accueil");
    }

    #[Route('/test', name: 'test')]
    public function test(): Response
    {
        return new Response("page test");
    }

    #[Route('/user/{id}', name: 'user')]
    public function user($id): Response
    {
        return new Response("page user $id");
    }

    #[Route('/user/all', name: 'user_all', priority: 1)]
    public function userAll(): Response
    {
        return new Response("page users");
    }

    #[Route('/user/{id}/show', name: 'user_show')]
    public function userShow($id): Response
    {
        return new Response("page user $id");
    }

    #[Route('/blog/{year<20\d{2}>}/{month}/{day}/{slug}', name: 'article',
        requirements: [
            'year' => '20\d{2}',
            'month' => '\d{2}',
            'day' => '\d{2}',
        ],

    )]
    public function article($slug, $year, $month, $day): Response
    {
        return new Response("page article $slug");
    }

    #[Route('/blog/{year}/{month}/{day?}', name: 'articles',
        defaults: [
            'day' => null
        ],
        methods: ['GET']
    )]
    public function articles($year, $month, $day=null): Response
    {
        dump($year, $month, $day);
        return new Response("<body>page articles $year $month $day</body>");
    }
}
