<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < UserFixtures::NB_OF_ARTIST; $i++) {
            $artist = new Artist();
            $artist->setAboutMe($faker->paragraph(8));
            $artist->setUser($this->getReference('Artist_' . $i));
            $this->setReference('Artist_' . $i, $artist);

            $manager->persist($artist);
        }
        $manager->flush();
    }

     public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    } 
}