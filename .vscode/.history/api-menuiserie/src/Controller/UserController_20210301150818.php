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
         * @Route("/api/user", name="api_user_create",methods={"POST"})
         * @return JsonResponse
         */
        public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        
        if($request->isMethod("POST")){
        $password=$request->request->get('password');
        $email=$request->request->get('email');
        $firstName=$request->request->get('firstName');
        $lastName=$request->request->get('lastName');
        $user = new User();
        $user->setPassword($encoder->encodePassword($user, $password))
             ->setEmail($email)
             ->setRoles("ROLE_USER")
             ->setFirstname($firstName)
             ->setLastname($lastName);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
    }

        //  return $this->render("home.html.twig");
        return new JsonResponse([null,JsonResponse::HTTP_NO_CONTENT]);
       

    }
    
        
}

