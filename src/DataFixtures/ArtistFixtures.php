<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistFixtures extends Fixture /* implements DependentFixtureInterface */
{
    public const NB_ARTIST = 20;
 
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < self::NB_ARTIST; $i++) {
            $artist = new Artist();
            $artist->setAboutMe($faker->paragraph(8));

            $this->addReference('Artist_' . $i, $artist);
            $manager->persist($artist);
        }
        $manager->flush();
    }

/*     public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    } */
}