<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $category = (new Categories());
            $category->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setTitle($faker->title())
                ->setDescription($faker->words(20, true));
            $manager->persist($category);
            $this->addReference('categorie' . $i, $category);
        }
        $manager->flush();
    }
}