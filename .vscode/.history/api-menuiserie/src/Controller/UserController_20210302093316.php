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
    // public function index(UserRepository $userRepository,SerializerInterface $serializer)
    // {
    //     $users = $userRepository->findAll();
    //     $json= $serializer->serialize($users,'json',['groups'=>'user:read']);
        
    //     $response= new JsonResponse($json,200,[],true);
    //     return $response;
        
    // }
         /**
         * @Route("/api/register-user", name="api_user_register",methods={"POST","GET"})
         * @return JsonResponse
         */
        public function register(Request $request, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        
        if($request->isMethod("POST")){
        $password=$request->request->get('password');
        $email=$request->request->get('email');
        $firstName=$request->request->get('firstName');
        $lastName=$request->request->get('lastName');
        $user = new User();
        $user->setPassword($encoder->encodePassword($user, $password))
             ->setEmail($email)
             ->setRoles('ROLE_USER')
             ->setFirstname($firstName)
             ->setLastname($lastName);
      
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        
    }

        return $this->render("home.html.twig");
        // return new JsonResponse([[],JsonResponse::HTTP_NO_CONTENT]);
       

    }

     /**
         * @Route("/api/login", name="api_user_login",methods={"POST","GET"})
         * @return JsonResponse
         */
        public function login(Request $request, UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,EntityManagerInterface $em)
        {
            $response =[
                'status'=>'200 OK',
                'error'=> false,
                'erroMsg'=>'',
                'user'=>null
            ];

            if($request->isMethod("POST")){
                $password=$request->request->get('password');
                $email=$request->request->get('email');
                //on cherche un user qui a le bon mail
                $user= $this->getDoctrine()->getRepository(User::class)->findOneByEmail($email);
                //aucun user trouvé avec le bon mail
                if(!$user){
                    $response['error']= true;
                    $response['errorMsg'] = "Email non trouvé";
                }
                //un utilisateur a été trouvé mais les verifications ne sont pas finis
                else{
                    if(!$encoder->isPasswordValid($user,$password)){
                        $response['error']= true;
                        $response['errorMsg'] = "Mot de passe non valide";
                    }
                    else{
                        $response['error']= false;
                        $response['errorMsg'] ="" ;
                        $response['user']=[
                            'firstName'=>$user->getFirstName(),
                            'lastName'=>$user->getLastName(),
                            'email'=>$user->getEmail(),
                        ];
                    }
                }
                
            }
            //je suis en get
            else{
                return new JsonResponse($response);
            }
        }
    
        
}

