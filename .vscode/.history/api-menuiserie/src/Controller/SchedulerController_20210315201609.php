<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SchedulerController extends AbstractController
{
    /**
     * @Route("/scheduler", name="scheduler")
     */
    public function index(): Response
    {
        return $this->render('scheduler/index.html.twig', [
            'controller_name' => 'SchedulerController',
        ]);
    }
}
