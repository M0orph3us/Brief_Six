<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTimeImmutable;
use DateTimeZone;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $timeZone = new DateTimeZone('Europe/Paris');
        for ($i = 0; $i < 10; $i++) {
            $category = (new Categories())
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setTitle()
                ->setDescription();
            // $manager->persist($category);
        }
        $manager->flush();
    }
}
