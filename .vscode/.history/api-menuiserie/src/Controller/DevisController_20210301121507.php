<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


class DevisController extends AbstractController
{
   
    /**
     * @Route("/api/devis", name="api_devis_index",methods={"GET"})
     */
    public function index(DevisRepository $devisRepository,SerializerInterface $serializer)
    {
        $devis = $devisRepository->findAll();
        $json= $serializer->serialize($devis,'json',['groups'=>'devis:read']);
        
        // $response = new Response($json,200,[
        //     "Content-Type"=>"application/json"
        // ]);
        $response= new JsonResponse($json,200,[],true);
        return $response;
        
    }

    /**
     * @Route("/api/devis", name="api_devis_add",methods={"POST","GET"})
     */
    // public function add(Request $request)
    // {
        // if($request->isMethod("POST")){
        // $name=$request->request->get('name');
        // $phone=$request->request->get('phone');
        // $mail=$request->request->get('mail');
        // $address=$request->request->get('address');
        // $city=$request->request->get('city');
        // $zipcode=$request->request->get('zipcode');
        // $subject=$request->request->get('subject');
        // $message=$request->request->get('message');
        // $devis = new Devis();
        // $devis->setName($name)
        //      ->setPhone($phone)
        //      ->setMail($mail)
        //      ->setAddress($address)
        //      ->setCity($city)
        //      ->setZipcode($zipcode)
        //      ->setSubject($subject)
        //      ->setMessage($message);
        // $this->getDoctrine()->getManager()->persist($devis);
        // $this->getDoctrine()->getManager()->flush();
       
    // }
  

    // return $this->render("devis.html.twig");
        // return new JsonResponse([null,JsonResponse::HTTP_NO_CONTENT]);
       

    // }
    

    
}
