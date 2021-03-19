<?php

namespace App\Controller;

use App\Entity\Scheduler;
use App\Repository\SchedulerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SchedulerController extends AbstractController
{

    /**
     * @Route("/api/scheduler/{idUser}", name="api_scheduler_index",methods={"GET"})
     */
    public function index(SchedulerRepository $schedulerRepository, SerializerInterface $serializer)
    {

        $this->getUser();
        // var_dump($this->getUser());

        $schedulers = $schedulerRepository->findAll();

        $json = $serializer->serialize($schedulers, 'json', ['groups' => 'scheduler:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }

    /**
     * @Route("/api/add-scheduler/{idUser}", name="api_scheduler_add",methods={"POST"})
     */
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        try {


            $jsonRecu = $request->getContent();
            $scheduler = $serializer->deserialize($jsonRecu, Scheduler::class, 'json');
            $scheduler->setIdUser($this->getUser());
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

    /**
     * @Route("/api/remove-scheduler/{id}", name="api_scheduler_remove",methods={"DELETE","GET"})
     */
    public function remove(Scheduler $scheduler)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($scheduler);
        $em->flush();

        return   $this->json($scheduler, 201, [], ['groups' => 'scheduler:read']);
    }

    /**
     * @Route("/api/update-scheduler/{id}", name="api_scheduler_update",methods={"POST"})
     */
    // public function update(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    // {


    //     try {

    //         $jsonRecu = $request->getContent();
    //         $scheduler = $serializer->deserialize($jsonRecu, Scheduler::class, 'json');
    //         $em->persist($scheduler);
    //         $em->flush();

    //         return $this->json($scheduler, 201, [], ['groups' => 'scheduler:read']);
    //     } catch (NotEncodableValueException $e) {
    //         return $this->json([
    //             'status' => 400,
    //             'message' => $e->getMessage()
    //         ], 400);
    //     }
    // }
}
