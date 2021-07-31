<?php

namespace App\Controller;

use App\Entity\Playground;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('project.html.twig');
    }

    #[Route('/map', name: 'map', methods: ['GET'])]
    public function playgrounds(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $playgrounds = $entityManager->getRepository(Playground::class)->findAll();
        return $this->json([
            'playgrounds' => $playgrounds,
        ]);
    }

}