<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\Realisations;
use App\Form\RealisationsType;
use App\Repository\PhotosRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RealisationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Serializer;

class RealisationsController extends AbstractController
{

    /**
     * @Route("/api/realisations", name="api_realisations_index",methods={"GET"})
     */
    public function index(RealisationsRepository $realisationsRepository, PhotosRepository $photosRepository, SerializerInterface $serializer)
    {

        return $this->render('realisations/index.html.twig', [
            'realisations' => $realisationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/api/add-realisations", name="api_realisations_add",methods={"POST","GET"})
     */
    public function new(Request $request): Response
    {
        $realisations = new Realisations();
        $form = $this->createForm(RealisationsType::class, $realisations);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Photos();
                $img->setNameImage($fichier);
                $realisations->setUpdatedAt(new \DateTime());
                $realisations->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($realisations);
            $entityManager->flush();

            // return $this->json($realisations, 201, [], ['groups' => 'realisations:read', 'photos:read']);
            return $this->redirectToRoute('api_realisations_index');
        }
        // return $this->json($realisations, 201, [], ['groups' => 'realisations:read', 'photos:read']);

        return $this->render('realisations/new.html.twig', [
            'realisations' => $realisations,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/api/realisation/{id}", name="realisations_show", methods={"GET"})
     */
    public function show(Realisations $realisations): Response
    {
        return $this->render('realisations/show.html.twig', [
            'realisation' => $realisations,
        ]);
    }

    /**
     * @Route("/api/realisation/{id}/edit", name="realisations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Realisations $realisation): Response
    {
        $form = $this->createForm(RealisationsType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Photos();
                $img->setNameImage($fichier);
                $realisation->setUpdatedAt(new \DateTime());
                $realisation->addImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('api_realisations_index');
        }

        return $this->render('realisations/edit.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/api/realisation/{id}", name="realisations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Realisations $realisation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $realisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($realisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('api_realisations_index');
    }

    /**
     * @Route("/supprime/image/{id}", name="realisations_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Photos $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $nom = $image->getNameImage();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
