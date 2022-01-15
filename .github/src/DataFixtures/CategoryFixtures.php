<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    const CATEGORIES = [
        'Historique',
        'Science-fiction',
        'Drame',
        'Thriller',
        'Horreur',
        'Aventure',
        'Animation',
        'Comedie'
    ];

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);

        }
        $manager->flush();
    }
}
