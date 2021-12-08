<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Service\Slugify;
use Faker;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYTUwOTM3ZGUtMDZiNy00M2I3LWI1ZWEtYzhhNGMyZjI3MjBmXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1.jpg'
        ],
        'The Haunting Of Hill House' => [
            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTU4NzA4MDEwNF5BMl5BanBnXkFtZTgwMTQxODYzNjM@._V1.jpg'
        ],
        'American Horror Story' => [
            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BODZlYzc2ODYtYmQyZS00ZTM4LTk4ZDQtMTMyZDdhMDgzZTU0XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1.jpg'
        ],
        'Love Death And Robots' => [
            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTc1MjIyNDI3Nl5BMl5BanBnXkFtZTgwMjQ1OTI0NzM@._V1.jpg'
        ],
        'Penny Dreadful' => [
            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYzRkMDNiM2YtZDNiYS00MzgzLThkNGMtZDAwZWRlMTViZDI4XkEyXkFqcGdeQXVyOTA3MTMyOTk@._V1.jpg'
        ],
        'Fear The Walking Dead' => [
            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYWNmY2Y1NTgtYTExMS00NGUxLWIxYWQtMjU4MjNkZjZlZjQ3XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1.jpg'
        ],
        'Alf' => [
            'summary' => 'Un sage extraterrestre à poils vient vivre avec la famille Tanner après s\'être écrasé dans leur garage. ',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYmRhNzk2YWUtNWIxNC00YWM3LWI5ODEtN2IwOGQzYWEwMWJjXkEyXkFqcGdeQXVyNTA4NzY1MzY@._V1.jpg'
        ],
        'The Big Bang Theory' => [
            'summary' => 'Leonard Hofstadter et Sheldon Cooper vivent en colocation à Pasadena, ville de l\'agglomération de Los Angeles. Ce sont tous deux des physiciens surdoués, « geeks » de surcroît. C\'est d\'ailleurs autour de cela qu\'est axée la majeure partie comique de la série. Ils partagent quasiment tout leur temps libre avec leurs deux amis Howard Wolowitz et Rajesh Koothrappali pour jouer à des jeux vidéo comme Halo, organiser un marathon de la saga Star Wars, jouer à des jeux de société comme le Boggle klingon ou de rôles tel que Donjons et Dragons, voire discuter de théories scientifiques très complexes.Leur univers routinier est perturbé lorsqu\'une jeune femme, Penny, s\'installe dans l\'appartement d\'en face. Leonard a immédiatement des vues sur elle et va tout faire pour la séduire ainsi que l\'intégrer au groupe et à son univers, auquel elle ne connaît rien.',
            'category' => 'categorie_7',
            'poster' => 'https://upload.wikimedia.org/wikipedia/fr/6/69/BigBangTheory_Logo.png'
        ],
    ];

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');
        $slugify = new Slugify();

        $i = 0;
        foreach (self::PROGRAMS as $title => $data) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster($data['poster']);
            $program->setSlug($slugify->generate($program->getTitle()));
            $program->setCategory($this->getReference($data['category']));

            $manager->persist($program);
            $this->addReference('program' . $i, $program);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
