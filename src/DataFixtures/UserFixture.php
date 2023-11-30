<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Wallet;

class UserFixture extends Fixture
{

    private $passwordHasher;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setEmail('mail@mail.com');
        $user->setUsername('Olivier');

        $user->setPassword($this->passwordHasher->hashPassword($user, '123'));

        $wallet = new Wallet();
        $wallet->setLabel("Crédits")->setCredits(1000)->setAuthor($user);

        $manager->persist($user);
        $manager->persist($wallet);
        $manager->flush();
    }
}
