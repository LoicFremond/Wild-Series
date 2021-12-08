<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Season;
use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class FakerFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $slugify = new Slugify();

        for ($i = 0; $i < 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->setSlug($slugify->generate($actor->getName()));
            $actor->addProgram($this->getReference( 'program' . rand(0, 5)));

            $manager->persist($actor);
        }

        for ($i = 0; $i <= 6; $i++) {
            if (!isset($k)) {
                $k = 0;
            }
            for ($j = 1; $j <= 6; $j++) {
                $season = new Season();
                $season->setNumber($j);
                $season->setYear($faker->year);
                $season->setDescription($faker->text);
                $season->setProgram($this->getReference('program' . $i));

                $manager->persist($season);
                $this->addReference('season' . $k, $season);
                $k++;
            }
        }

        for ($i = 0; $i < 42; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                $episode = new Episode();
                $episode->setTitle($faker->words(3, true));
                $episode->setNumber($j);
                $episode->setSynopsis($faker->text);
                $episode->setSlug($slugify->generate($episode->getTitle()));
                $episode->setSeason($this->getReference('season' . $i));

                $manager->persist($episode);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
