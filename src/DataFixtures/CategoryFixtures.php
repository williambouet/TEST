<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Dessin',
        'Peinture',
        'Photographie',
        'Tutoriel',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setPlaceholder($categoryName . '.jpg');
            $manager->persist($category);
        }
        $manager->flush();
    }
}
