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
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < UserFixtures::NB_OF_ARTIST; $i++) {
            for ($j = 0; $j < rand(1, 10); $j++) {
                $artwork = new Artwork();
                $artwork->setArtist($this->getReference('Artist_' . $i));
                $artwork->setName($faker->text($faker->numberBetween(5, 100)));
                $artwork->setTool($faker->word());
                $artwork->setHeight($faker->numberBetween(10, 100));
                $artwork->setWidth($faker->numberBetween(10, 100));
                $artwork->setBase($faker->word());
                $artwork->setWorkDuration($faker->numberBetween(10, 1000));

                $manager->persist($artwork);
            }
        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
        ];
    }
}
