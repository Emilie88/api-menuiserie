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
     * @Route("/api/add-devis", name="api_devis_add",methods={"POST","GET"})
     */
     public function add(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        try{

      
        $jsonRecu = $request->getContent();
        $devisOne=$serializer->deserialize($jsonRecu,Devis::class,'json');
        $em->persist($devisOne);
        $em->flush();
      
        return $this->json($devisOne,201,[],['groups'=>'devis:read']);
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ],400);

        }
        



    }
    

    
}
