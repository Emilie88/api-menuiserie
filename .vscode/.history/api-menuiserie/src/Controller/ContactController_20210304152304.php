<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ContactController extends AbstractController
{
   
   
    
       
        /**
         * @Route("/api/contacts", name="api_contact_index",methods={"GET"})
         */
        public function index(ContactRepository $contactRepository,SerializerInterface $serializer)
        {
            $contacts = $contactRepository->findAll();
            $json= $serializer->serialize($contacts,'json',['groups'=>'contact:read']);
           
            $response= new JsonResponse($json,200,[],true);
            return $response;
            
        }
    
        /**
         * @Route("/api/add-contact", name="api_contact_add",methods={"POST","GET"})
         */
         public function add(Request $request,SerializerInterface $serializer,EntityManagerInterface $em,ValidatorInterface $validator)
        {
            try{
    
          
            $jsonRecu = $request->getContent();
            $contact=$serializer->deserialize($jsonRecu,Contact::class,'json');
            $contact->setDate(new \DateTime());
            $errors = $validator->validate( $contact);
            if(count($errors) > 0){
                return $this->json($errors,400);
            }
            $em->persist($contact);
            $em->flush();
          
            return $this->json($contact,201,[],['groups'=>'contact:read']);
            }catch(NotEncodableValueException $e){
                return $this->json([
                    'status'=> 400,
                    'message'=> $e->getMessage()
                ],400);
    
            }
            
        }
    }
    
    

    

