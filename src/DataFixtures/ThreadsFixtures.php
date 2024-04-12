<?php

namespace App\DataFixtures;

use App\Entity\Threads;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ThreadsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $thread = (new Threads());
            $thread->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->DateTime()))
                ->setStatus('Open')
                ->setTitle($faker->title())
                ->setDescription($faker->words(20, true))
                ->setBody($faker->paragraphs(1, true))
                ->setUsers($this->getReference('user' . $i));
            $manager->persist($thread);
            $this->addReference('thread' . $i, $thread);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UsersFixtures::class];
    }
}