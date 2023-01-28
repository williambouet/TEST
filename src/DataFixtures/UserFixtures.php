<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public const NB_OF_ARTIST = 20;
    public const NB_OF_ADMIN = 1;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_OF_ARTIST; $i++) {
            $user = new User();
            $user->setEmail('artist_' . $i . '@exemple.com');
            $user->setRoles(['ROLE_ARTIST']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'artist_' . $i);
            $user->setPassword($hashedPassword);
            $user->setLastname($faker->lastName());

            $this->addReference('Artist_' . $i, $user);
            $manager->persist($user);
        }

        for ($i = 0; $i < self::NB_OF_ADMIN; $i++) {
            $user = new User();
            $user->setEmail('admin_' . $i . '@exemple.com');
            $user->setRoles(['ROLE_ADMIN']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'admin_' . $i);
            $user->setPassword($hashedPassword);
            $user->setLastname($faker->lastName());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
