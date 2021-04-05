<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Scheduler;
use Symfony\Component\Mime\Email;
use App\Repository\SchedulerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SchedulerController extends AbstractController
{

    /**
     * @Route("/api/schedulers", name="api_schedulers_index",methods={"GET"})

     */
    public function index(SchedulerRepository $schedulerRepository, SerializerInterface $serializer)
    {

        $this->getUser();

        $schedulers = $schedulerRepository->findAll();

        $json = $serializer->serialize($schedulers, 'json', ['groups' => 'scheduler:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }

    /**
     * @Route("api/scheduler", name="api_scheduler_scheduler",methods={"GET"}) 
     *  @IsGranted("IS_AUTHENTICATED_FULLY")
     */

    public function scheduler(SchedulerRepository $schedulerRepository,  SerializerInterface $serializer)
    {

        $idUs = $this->getUser();

        $scheduler = $schedulerRepository->findByIdUs($idUs);
        $json = $serializer->serialize($scheduler, 'json', ['groups' => 'scheduler:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }

    /**
     * @Route("/api/add-scheduler", name="api_scheduler_add",methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY") 
     * 
     */
    public function add(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        try {


            $jsonRecu = $request->getContent();
            $scheduler = $serializer->deserialize($jsonRecu, Scheduler::class, 'json');
            $scheduler->setIdUs($this->getUser());
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
     *  @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Scheduler $scheduler)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scheduler);
            $em->flush();


            // $email = (new Email())
            //     ->from('akysor@gmail.com')
            //     ->to('eboghiu88@gmail.com')
            //     // ->to($user->getEmail())
            //     ->subject("Votre rendez-vous a été annulé par l'admin");
            // dd($email);
            // $mailer->send($email);

            return $this->json(null, 204);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/api/update-scheduler/{id}", name="api_scheduler_update",methods={"PUT"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function update(Scheduler $scheduler, Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        try {
            $jsonRecu = $request->getContent();
            $serializer->deserialize($jsonRecu, Scheduler::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $scheduler]);

            $em->flush();


            return $this->json($scheduler, 201, [], ['groups' => 'scheduler:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json(
                [
                    'status'  => 400,
                    'message' => $e->getMessage(),
                ],
                400
            );
        }
    }
}
