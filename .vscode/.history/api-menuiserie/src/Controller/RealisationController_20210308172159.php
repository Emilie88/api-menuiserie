<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Repository\RealisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


class RealisationController extends AbstractController
{
   
    /**
     * @Route("/api/realisation", name="api_realisation_index",methods={"GET"})
     */
    public function index(RealisationRepository $realisationRepository,SerializerInterface $serializer)
    {
        $realisation = $realisationRepository->findAll();
        $json= $serializer->serialize($realisation,'json',['groups'=>'realisation:read']);
        
        // $response = new Response($json,200,[
        //     "Content-Type"=>"application/json"
        // ]);
        $response= new JsonResponse($json,200,[],true);
        return $response;
        
    }

    /**
     * @Route("/api/add-realisation", name="api_realisation_add",methods={"POST","GET"})
     */
     public function add(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        // try{

      
        $jsonRecu = $request->getContent();
        $realisationOne=$serializer->deserialize($jsonRecu,Realisation::class,'json');
        $em->persist($realisationOne);
        $em->flush();
      
        return $this->render("realisation.html.twig");
        // return $this->json($realisationOne,201,[],['groups'=>'realisation:read']);
        // }catch(NotEncodableValueException $e){
        //     return $this->json([
        //         'status'=> 400,
        //         'message'=> $e->getMessage()
        //     ],400);

        // }
        



    }
    

    
}
