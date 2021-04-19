<?php


namespace App;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Topic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class TopicPersister implements DataPersisterInterface
{
    private $slugger;
    private $em;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function supports($data): bool
    {
       return $data instanceof Topic;
    }

    public function persist($data)
    {
        /* @var Topic $data */
        $slug = $this->slugger->slug($data->getTitle());
        $data->setSlug($slug);

        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        // TODO: Implement remove() method.
    }

}