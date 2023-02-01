<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\ArtistFixtures;
use App\DataFixtures\ArtworkFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < UserFixtures::NB_OF_ARTIST; $i++) {
            for ($j = 0; $j < ArtworkFixtures::NUMBER_OF_ARTWORK; $j++) {
                for ($k = 0; $k < ArtworkFixtures::NUMBER_OF_ARTWORK; $k++) {
                    
                    $comment = new Comment();
                    $comment->setComment($faker->realText());
                    $comment->setArtwork($this->getReference('Artwork_' . $i . '_' . $j));
                    $comment->setAuthor($this->getReference('Artist_' . $faker->numberBetween(0, UserFixtures::NB_OF_ARTIST - 1)));
                    $comment->setCreationDate($faker->dateTime());

                    $manager->persist($comment);
                }
            }
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
            ArtworkFixtures::class,
        ];
    }
}
