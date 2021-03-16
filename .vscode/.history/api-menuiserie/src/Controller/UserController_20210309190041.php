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
    public function index(UserRepository $userRepository,SerializerInterface $serializer)
    {
        $users = $userRepository->findAll();
        $json= $serializer->serialize($users,'json',['groups'=>'user:read']);
        
        $response= new JsonResponse($json,200,[],true);
        return $response;
        
    }
         /**
         * @Route("/api/register-user", name="api_user_register",methods={"POST","GET"})
         * @return JsonResponse
         */
        public function register(Request $request, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        
        if($request->isMethod("POST")){
        $user = new User();
        $user->setEmail($request->request->get('email'));
        $user->setPassword($encoder->encodePassword(
            $user,
            $request->request->get('password')
        ));
        $user->setFirstname($request->request->get('firstName'));
        $user->setLastname($request->request->get('lastName'));
        var_dump($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        
    }

        // return $this->render("home.html.twig");
        return new JsonResponse([[],JsonResponse::HTTP_NO_CONTENT]);
       

    }

    
        
}

