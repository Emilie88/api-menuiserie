<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


class CommentController extends AbstractController
{

    /**
     * @Route("api/comments", name="api_comments_index",methods={"GET"})
      
     */
    public function index(CommentRepository $commentRepository,  SerializerInterface $serializer)
    {

        $this->getUser();

        $comment = $commentRepository->findAll();
        $json = $serializer->serialize($comment, 'json', ['groups' => 'comment:read']);

        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }

    /**
     * @Route("api/add-comment", name="api_opinion_create",methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY") 
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
            $comment->setIdUser($this->getUser());

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
