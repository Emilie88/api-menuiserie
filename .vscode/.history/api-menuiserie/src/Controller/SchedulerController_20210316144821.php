<?php

namespace App\Controller;

use App\Entity\Scheduler;
use App\Repository\SchedulerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class SchedulerController extends AbstractController
{

    /**
     * @Route("/api/scheduler", name="api_scheduler_index",methods={"GET"})
     */
    public function index(SchedulerRepository $schedulerRepository, SerializerInterface $serializer)
    {
        $schedulers = $schedulerRepository->findAll();
        $json = $serializer->serialize($schedulers, 'json', ['groups' => 'scheduler:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }

    /**
     * @Route("/api/add-scheduler", name="api_scheduler_add",methods={"POST","GET"})
     */
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        try {


            $serializer = new Serializer(array(new DateTimeNormalizer()));

            $dateAsString = $serializer->normalize(
                new \DateTime('2021-03-16 05:30'),
                null,
                array(DateTimeNormalizer::FORMAT_KEY => 'Y-m-d h-m')
            );

            $jsonRecu = $request->getContent();
            $scheduler = $serializer->deserialize($jsonRecu, Scheduler::class, 'json');
            $scheduler->setStart($dateAsString);
            $scheduler->setEnd($dateAsString);
            $em->persist($scheduler);
            $em->flush();

            return $this->json($scheduler, 201, [], ['groups' => 'scheduler:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
