<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private $passwordHasher; 
    
    public function __construct(UserPasswordHasherInterface $passwordHasher) { $this->passwordHasher = $passwordHasher; }

    public function load(ObjectManager $manager)
    {
        $user = new User(); $user->setLogin('qwe'); $user->setHash($this->passwordHasher->hashPassword($user, '123'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
    }
}
