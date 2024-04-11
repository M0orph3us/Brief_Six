<?php

namespace App\DataFixtures;

use App\Entity\Users;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $timeZone = new DateTimeZone('Europe/Paris');
        for ($i = 0; $i < 10; $i++) {
            $user = (new Users())
                // ->addVote()
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setUsername()
                ->setPassword()
                ->setRoles(['ROLE_USER'])
                ->setEmail();
            // $manager->persist($user);
        }


        $manager->flush();
    }
}
