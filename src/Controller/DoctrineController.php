<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Tag;
use App\Entity\Topic;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DoctrineController extends AbstractController
{
    #[Route('/doctrine/list', name: 'doctrine_list')]
    public function index(EntityManagerInterface $em, TopicRepository $topicRepo): Response
    {
        // récupéré du manager
        $topicRepository = $em->getRepository(Topic::class);

        // injecté dans la méthode du controller
        // $topicRepo;

        // récupérer toutes les entités d'un certain type
        $topics = $topicRepo->findAll();
        dd($topics);
    }

    #[Route('/doctrine/insert', name: 'doctrine_insert')]
    public function insert(EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $topic = new Topic();
        $topic->setCreatedAt(new \DateTime());
        $topic->setTitle("Mon titre avec comments");
        $topic->setDescription("Ma description");
        $topic->setSlug($slugger->slug("Mon titre Comments"));

        $message = new Message();
        $message->setCreatedAt(new \DateTime());
        $message->setText("Coucou mon message !");
        //$message->setTopic($topic);
        $topic->addMessage($message);

        $tag = new Tag();
        $tag->setText("PHP");
        $tag->addTopic($topic);

        //$em->persist($message);
        //$em->persist($tag);
        $em->persist($topic);
        $em->flush();

        return new Response("<body>Topic créé</body>");
    }

    #[Route('/doctrine/update/{id}', name: 'doctrine_update')]
    public function update(EntityManagerInterface $em, TopicRepository $topicRepo, $id): Response
    {
        $topic = $topicRepo->find($id);

        if (!$topic) {
            throw new NotFoundHttpException("existe pas !");
        }

        $topic->setTitle("Titre modifié");

        $em->flush();

        return new Response("<body>Topic modifié</body>");
    }

    #[Route('/doctrine/update2/{id}', name: 'doctrine_update')]
    public function update2(EntityManagerInterface $em, Topic $topic): Response
    {
        $topic->setTitle("Titre modifié");
        $em->flush();

        return new Response("<body>Topic modifié</body>");
    }

    #[Route('/doctrine/read/{slug}', name: 'doctrine_read')]
    /*
     * ParamConverter récupère automatiquement l'entité
     */
    public function read(Topic $topic): Response
    {
        return new Response("<body>".$topic->getTitle()."</body>");
    }

    #[Route('/doctrine/delete/{id}', name: 'doctrine_delete')]
    public function delete(EntityManagerInterface $em, Topic $topic): Response
    {
        $em->remove($topic);
        $em->flush();

        return new Response("<body>Topic supprimé</body>");
    }

    #[Route('/doctrine/repo', name: 'doctrine_repo')]
    public function repo(TopicRepository $topicRepo): Response
    {
        $topic = $topicRepo->findOneBy(['slug' => 'mon-titre', 'description' => 'description']);
        $topic = $topicRepo->findOneBy([
            'slug' => ['mon-titre', 'mon-titre2'],
            'description' => 'description'
        ]);

        $topics = $topicRepo->findBy([
            'slug' => ['mon-titre', 'mon-titre2'],
            'description' => 'description'
        ], ['slug' => 'ASC', 'description' => 'DESC'], 10, 2);

        $testTopics = $topicRepo->findByTitleContains("test");

        return new Response("<body>Topic recherché</body>");
    }


}
