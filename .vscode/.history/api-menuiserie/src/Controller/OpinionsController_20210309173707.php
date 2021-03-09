<?php

namespace App\Controller;

use App\Entity\Opinions;
use App\Repository\OpinionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;


class CommentController extends AbstractController
{
    
    /**
     * @Route("api/opinions", name="api_opinions_index",methods={"GET"})
      
     */
    public function index(OpinionsRepository $opinionsRepository,Request $request)
    {
       
        $opinions = $opinionsRepository->findAll();
        $this->getUser();
        $response = $this->json($opinions,200,[],['groups'=>'opinions:read']);
       
        return $response;
    }

     /**
     * @Route("api/opinion", name="api_opinion_create",methods={"POST","GET"})
     *  @IsGranted("ROLE_USER")
     */
    public function create(Request $request,SerializerInterface $serializer,EntityManagerInterface $em,
    ValidatorInterface $validator){
       
      
       try{
        $jsonRecu = $request->getContent();
        $opinions = $serializer->deserialize($jsonRecu,Opinions::class,'json');
        $opinions->setCreatedAt(new \DateTime());
        $opinions->setOpinion($this->getUser());
        $errors = $validator->validate( $opinions);
        if(count($errors) > 0){
            return $this->json($errors,400);
        }
        $em->persist($opinions);
        $em->flush();

       return $this->json($opinions, 201,[],['groups'=>'opinions:read']);
       }catch(NotEncodableValueException $e){
           return $this->json([
               'status'=>400,
               'message'=>$e->getMessage()
           ],400);
       }
    
    }
}
