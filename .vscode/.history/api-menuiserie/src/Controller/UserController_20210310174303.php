<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserController extends AbstractController
{

    /**
     * @Route("/api/users", name="api_devis_index",methods={"GET"})
     */
    public function index(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $users = $userRepository->findAll();
        $json = $serializer->serialize($users, 'json', ['groups' => 'user:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
    /**
     * @Route("/api/register-user", name="api_user_register",methods={"POST","GET"})
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        // if ($request->isMethod("POST")) {
        //     $email = $request->get('email');
        //     $password = $request->get('password');
        //     $firstName = $request->get('firstName');
        //     $lastName = $request->get('lastName');
        //     $user = new User();
        //     var_dump($email);
        //     $user->setEmail($email)
        //         ->setPassword($encoder->encodePassword($user, $password))

        //         ->setRoles(['ROLE_USER'])
        //         ->setFirstname($firstName)
        //         ->setLastname($lastName);

        //     $em->persist($user);
        //     $em->flush();
        // }

        try {
            $jsonRecu = $request->getContent();
            $user = $serializer->deserialize($jsonRecu, Contact::class, 'json');
            $user->setEmail($email)
                ->setPassword($encoder->encodePassword($user, $password))

                ->setRoles(['ROLE_USER'])
                ->setFirstname($firstName)
                ->setLastname($lastName);
            // $errors = $validator->validate($contact);
            // if (count($errors) > 0) {
            //     return $this->json($errors, 400);
            // }
            $em->persist($user);
            $em->flush();

            return $this->json($user, 201, [], ['groups' => 'contact:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

        // return $this->render("home.html.twig");
        // return new JsonResponse([[],JsonResponse::HTTP_NO_CONTENT]);


    }
}
