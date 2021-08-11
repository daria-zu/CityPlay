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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Controller extends AbstractController
{
    #[Route('/maps', name: 'maps')]
    public function playgrounds(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $playgrounds = $entityManager->getRepository(Playground::class)->findAll();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonObject = $serializer->serialize($playgrounds, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['reviews']
        ]);

        return $this->json(['playgrounds' => $jsonObject]);
    }

    #[Route('/', name: 'index')]
    #[Route('/map', name: 'vue_pages', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('project.html.twig');
    }

    #[Route('/auth', name: 'login', methods: ['POST'])]
    public function getAuth(): Response
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }

    #[Route('/checkauth', name: 'check_auth', methods: ['GET'])]
    public function check_auth(): Response
    {
        if ($this->getUser()){
            return $this->json(['message' => true]);
        }
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
     
    }

    #[Route('/reg', name: 'reg', methods: ['POST'])]
    public function getReg(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
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
            'message' => 'success',
        ]);
    }
}