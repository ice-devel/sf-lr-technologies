<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/_api')]
class ApiController extends AbstractController
{
    #[Route('/', name: 'api_index', methods: ['GET'])]
    public function index(TopicRepository $topicRepository, NormalizerInterface $normalizer): Response
    {
        $topics = $topicRepository->findAll();

        // normalization + json_encode = serialization
        $normalizedTopics = $normalizer->normalize($topics, null, ['groups' => 'topic:read']);
        $json = json_encode($normalizedTopics);

        //return new Response($json, 200, ['Content-Type' => 'application/json']);
        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/2', name: 'api2_index', methods: ['GET'])]
    public function index2(TopicRepository $topicRepository, NormalizerInterface $normalizer, SerializerInterface $serializer): Response
    {
        $topics = $topicRepository->findAll();

        // normalization + json_encode = serialization
        //$normalizedTopics = $normalizer->normalize($topics, null, ['groups' => 'topic:read']);
        //return new JsonResponse($normalizedTopics);

        $serializedTopics = $serializer->serialize($topics, 'json', ['groups' => 'topic:read']);
        return new JsonResponse($serializedTopics, 200, [], true);
    }

    #[Route('/3', name: 'api3_index', methods: ['GET'])]
    public function index3(TopicRepository $topicRepository): Response
    {
        return $this->json($topicRepository->findAll(), 200, [], ['groups' => 'topic:read']);
    }

    #[Route('/', name: 'api_post', methods: ['POST'])]
    public function post(Request $request, SerializerInterface $serializer,
                         SluggerInterface $slugger, ValidatorInterface $validator): Response
    {
        $content = $request->getContent();
        // denormalize / deserialize

        try {
            $topic = $serializer->deserialize($content, Topic::class, 'json');

            $errors = $validator->validate($topic);

            if (count($errors) > 0) {
                return $this->json($errors);
            }

            $slug = $slugger->slug($topic->getTitle());
            $topic->setSlug($slug);

            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->json([
                'status' => 201,
                'message' => 'Topic enregistré'
            ], 201);
        }
        catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => 'Erreur de json'
            ], 400);
        }
    }

    #[Route('/{id}', name: 'api_delete', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(Topic::class)->find($id);
        $em->remove($topic);
        $em->flush();
    }
}
