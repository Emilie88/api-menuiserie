<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        try {
            $jsonRecu = $request->getContent();
            $user = $serializer->deserialize($jsonRecu, User::class, 'json');
            $user->setPassword($encoder
                ->encodePassword($user, $user->getPassword()))
                ->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();

            return $this->json($user, 201, [], ['groups' => 'user:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/api/remove-user/{id}", name="api_user_remove",methods={"DELETE"})
     *  @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function removeUser(User $user)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            return   $this->json(null, 204);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    //     public function edituserPassword(User $user, $newPassword, $em)
    // {
    //     $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
    //     $newPasswordEncoded = $encoder->encodePassword($newPasswordd, $user->getSalt());
    //     $user->setPassword($newPasswordEncoded);
    //     $em->persist($user);
    //     $em->flush();
    // }
}
