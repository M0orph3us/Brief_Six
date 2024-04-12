<?php

namespace App\DataFixtures;

use App\Entity\Responses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ResponsesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $response = (new Responses());
            $response->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setBody($faker->paragraphs(5, true))
                ->setUsers($this->getReference('user' . $i))
                ->setThreads($this->getReference('thread' . $i));
            $manager->persist($response);
            $this->addReference('response' . $i, $response);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [UsersFixtures::class, ThreadsFixtures::class];
    }
}