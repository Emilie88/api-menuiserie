<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
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
     * @Route("api/comments", name="api_comments_index",methods={"GET"})
      
     */
    public function index(CommentRepository $commentRepository, Request $request)
    {



        $comment = $commentRepository->findAll();
        $response = $this->json($comment, 200, [], ['groups' => 'comment:read']);

        return $response;
    }

    /**
     * @Route("api/comment", name="api_opinion_create",methods={"POST"})
   
     */
    public function create(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ) {





        try {
            $jsonRecu = $request->getContent();
            $comment = $serializer->deserialize($jsonRecu, Comment::class, 'json');
            $comment->setCreatedAt(new \DateTime());
            $comment->setUserId($this->getUser());
            var_dump($this->getUser());



            $em->persist($comment);
            $em->flush();

            return $this->json($comment, 201, [], ['groups' => 'comment:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
