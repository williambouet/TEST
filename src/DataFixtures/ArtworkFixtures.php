<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artwork;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtworkFixtures extends Fixture  implements DependentFixtureInterface
{
    public const TOOLS = [
        'Crayon de papier',
        'Feutres à alcool',
        'Gouache',
        'Peinture à l\'eau',
        'Peinture acrylique',
        'Couteaux',
        'Pastel',
    ];
    public const NUMBER_OF_ARTWORK = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < UserFixtures::NB_OF_ARTIST; $i++) {
            for ($j = 0; $j < self::NUMBER_OF_ARTWORK; $j++) {
                $artwork = new Artwork();
                $artwork->setArtist($this->getReference('Artist_' . $i));
                $artwork->setName($faker->text($faker->numberBetween(5, 100)));
                $random_keys=array_rand(self::TOOLS);
                $artwork->setTool(self::TOOLS[$random_keys]);
                $random_keys=array_rand(CategoryFixtures::CATEGORIES);
                $artwork->setCategory($this->getReference(CategoryFixtures::CATEGORIES[$random_keys]));
                $artwork->setHeight($faker->numberBetween(10, 100));
                $artwork->setWidth($faker->numberBetween(10, 100));
                $artwork->setBase($faker->word());
                $artwork->setWorkDuration($faker->numberBetween(10, 1000));

                $this->setReference('Artwork_' . $i . '_' . $j, $artwork);

                $manager->persist($artwork);
            }
        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
