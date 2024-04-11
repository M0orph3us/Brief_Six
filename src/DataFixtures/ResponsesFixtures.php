<?php

namespace App\DataFixtures;

use App\Entity\Responses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTimeImmutable;
use DateTimeZone;

class ResponsesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $timeZone = new DateTimeZone('Europe/Paris');
        for ($i = 0; $i < 10; $i++) {
            $response = (new Responses())
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setBody();
            // $manager->persist($response);
        }

        $manager->flush();
    }
}
