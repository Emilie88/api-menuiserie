<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\Realisations;
use App\Form\RealisationsType;
use App\Repository\PhotosRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RealisationsRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class RealisationsController extends AbstractController
{

    /**
     * @Route("/api/realisations", name="api_realisations_index",methods={"GET"})
     */
    public function index(RealisationsRepository $realisationsRepository, PhotosRepository $photosRepository, SerializerInterface $serializer)
    {
        //https://openclassrooms.com/forum/sujet/creer-un-objet-json-avec-symfony
        $realisations = $realisationsRepository->findAll();

        // for ($i = 0; $i < count($realisations); $i++) {
        //     $testArray = $realisations[$i]->images;
        // }
        // array_push($realisations,  $testArray);
        // dd($realisations);

        $json = $serializer->serialize($realisations, 'json', ['groups' => 'realisations:read', 'photos:read']);

        $decode = json_decode($json);
        // $images = $response[3]->images;
        // dd($images[0]->getNameImage());
        $response = new JsonResponse($decode);

        return $response;

        // $response->getImages();
        // dd($json);
        /**
         * data stocke toutes les données qui seront transformées en json
         */
        // $data = [];

        // foreach ($realisations as $realisation) {
        //     $data[] = [
        //         'title' => $realisation->getTitle(),
        //         'description' => $realisation->getDescription(),
        //         'images' => $realisation->getImages()
        //     ];
        // }$response


    }

    /**
     * @Route("/api/add-realisations", name="api_realisations_add",methods={"POST","GET"})
     
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $realisations = new Realisations();
        $form = $this->createForm(RealisationsType::class, $realisations);
        $form->submit($request->request->all());
        $form->handleRequest($request);
        // dd($form);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($request->files->has('images') && $request->files->get('images')) {
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

                    $realisations->addImage($img);
                }
            }



            return $this->json($realisations, 201, [], ['groups' => 'realisations:read']);
        }
        $realisations->setUpdatedAt(new \DateTime());
        $em->persist($realisations);
        $em->flush();


        return $this->json($realisations, 201, [], ['groups' => 'realisations:read']);
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
