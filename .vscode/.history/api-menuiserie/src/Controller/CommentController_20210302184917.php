<?php

namespace App\Controller;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class CommentController extends AbstractController
{
    
    /**
     * @Route("api/comments", name="api_comment_index",methods={"GET"})
     */
    public function index(CommentRepository $commentRepository,Request $request)
    {
        $comments = $commentRepository->findAll();
        $this->getUser();
        $response = $this->json($comments,200,[],['groups'=>'comment:read']);
       
        return $response;
    }

     /**
     * @Route("api/comment", name="api_comment_create",methods={"POST"})
     */
    public function create(Request $request,SerializerInterface $serializer,EntityManagerInterface $em,
    ValidatorInterface $validator){
        
        if($request->isMethod("POST")){
            $rating=$request->request->get('rating');
            $author=$request->request->get('author');
            $title=$request->request->get('title');
            $content=$request->request->get('content');
           
            $comment = new Comment();
            $owner=$comment->getOwner();
            $comment->setRating($rating)
                 ->setAuthor($author)
                 ->setTitle($title)
                 ->setContent($content)
                 ->setOwner($owner);
          
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            
        }
    
            // return $this->render("home.html.twig");
            return new JsonResponse([[],JsonResponse::HTTP_NO_CONTENT]);
           
    
        }
        
    //    try{
    //     $jsonRecu = $request->getContent();
    //     $comment = $serializer->deserialize($jsonRecu,Comment::class,'json');
    //     $comment->setCreatedAt(new \DateTime());
    //     $errors = $validator->validate( $comment);
    //     if(count($errors) > 0){
    //         return $this->json($errors,400);
    //     }
    //     $em->persist($comment);
    //     $em->flush();

    //    return $this->json($comment, 201,[],['groups'=>'comment:read']);
    //    }catch(NotEncodableValueException $e){
    //        return $this->json([
    //            'status'=>400,
    //            'message'=>$e->getMessage()
    //        ],400);
    //    }
    
    // }
}
