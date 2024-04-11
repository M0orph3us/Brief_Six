<?php

namespace App\DataFixtures;

use App\Entity\Threads;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTimeImmutable;
use DateTimeZone;

class ThreadsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $timeZone = new DateTimeZone('Europe/Paris');
        for ($i = 0; $i < 10; $i++) {
            $thread = (new Threads())
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setStatus()
                ->setTitle()
                ->setDescription()
                ->setBody();
            // $manager->persist($thread);
        }

        $manager->flush();
    }
}
