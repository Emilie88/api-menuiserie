<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DevisController extends AbstractController
{
   
    /**
     * @Route("/devis", name="api_devis_index",methods={"GET"})
     */
    // public function index(DevisRepository $devisRepository,Request $request)
    // {
        // $devis = $devisRepository->findAll();
        // $devis = $request->getContent();
        
        // $response = $this->json($devis,200);
       
       
        // return $response;
    // }

    /**
     * @Route("/devis", name="api_devis_create",methods={"POST","GET"})
     */
    public function register(Request $request)
    {
        if($request->isMethod("POST")){
        $name=$request->request->get('name');
        $phone=$request->request->get('phone');
        $mail=$request->request->get('mail');
        $address=$request->request->get('address');
        $city=$request->request->get('city');
        $zipcode=$request->request->get('zipcode');
        $subject=$request->request->get('subject');
        $message=$request->request->get('message');
        $devis = new Devis();
        $devis->setName($name)
             ->setPhone($phone)
             ->setMail($mail)
             ->setAddress($address)
             ->setCity($city)
             ->setZipcode($zipcode)
             ->setSubject($subject)
             ->setMessage($message);
        $this->getDoctrine()->getManager()->persist($devis);
        $this->getDoctrine()->getManager()->flush();
       
    }
  

    return $this->render("devis.html.twig");
        // return new JsonResponse([null,JsonResponse::HTTP_NO_CONTENT]);
       

    }
    

    
}
