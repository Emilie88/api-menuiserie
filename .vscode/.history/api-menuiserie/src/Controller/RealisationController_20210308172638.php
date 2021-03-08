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
     *  @return JsonResponse
     */
     public function add(Request $request,SerializerInterface $serializer,EntityManagerInterface $em)
    {
        if($request->isMethod("POST")){
           
            $title=$request->request->get('title');
            $description=$request->request->get('description');
            $imageFile=$request->request->get('imageFile');
            $realisation = new Realisation();
            $realisation ->setTitle($title)
                 ->setDescription($description)
                 ->setImageFile($imageFile);
          
            $this->getDoctrine()->getManager()->persist($realisation);
            $this->getDoctrine()->getManager()->flush();
            
        }
    
        return $this->render("realisation.html.twig");
        
        



    }
    

    
}
