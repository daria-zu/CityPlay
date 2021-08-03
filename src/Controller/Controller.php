<?php

namespace App\Controller;

use App\Entity\Playground;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Controller extends AbstractController
{
    #[Route('/maps', name: 'maps')]
    public function playgrounds(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $playgrounds = $entityManager->getRepository(Playground::class)->findAll();
        return $this->json([
            'playgrounds' => $playgrounds,
        ]);
    }

    #[Route('/', name: 'index')]
    #[Route('/{page}', name: 'vue_pages', requirements: ['page' => '^.+'], methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('project.html.twig');
    }

    #[Route('/auth', name: 'form-auth', methods: ['POST'])]
    public function getAuth(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $registrationData = $request->request;

        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['login' => $registrationData->get('login')]);
        if ($user) {
            return $this->json([
                'message' => 'error',
            ]);
        }

        $user = new User();
        $user->setLogin($registrationData->get('login'));
        $hash = $passwordEncoder->hashPassword($user, $registrationData->get('password'));
        $user->setHash($hash);

        $user->setRoles(['ROLE_USER']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->json([
            'message' => 'success_reg',
        ]);
    }
}