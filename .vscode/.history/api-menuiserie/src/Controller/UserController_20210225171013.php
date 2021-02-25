<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
         * @Route("/create", name="api_user_create",methods={"POST"})
         */
        public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        dump($request);
        $password=$request->request->get('password');
        $email=$request->request->get('email');
        $firstName=$request->request->get('firstName');
        $lastName=$request->request->get('lastName');

        $user = new User();
        // $hash = $encoder->encodePassword($user, $password);
        $user->setPassword($encoder->encodePassword($user, $password))
             ->setEmail($email)
             ->setFirstname($firstName)
             ->setLastname($lastName);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->render("home.html");
       

    }
    /**
         * @Route("api/users/login", name="api_user_login",methods={"POST,GET"})
         */
    // public function login(Request $request,UserPasswordEncoderInterface )
    // {
    //     return $this->json([
    //         'user' => $this->getUser() ? $this->getUser()->getId() : null]
    //     );
    // }
        
    
        
}

