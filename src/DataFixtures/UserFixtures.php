<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setFirstName('kost')
            ->setLastName('stenko')
            ->setEmail('sten@sten.fr')
            ->setActive(false)
            ->setRoles(["ROLE_ADMIN"])

            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                '123'
            ));

        $manager->persist($user);


        $faker = Factory::create('fr__FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setActive(false);

            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                '123'
            ));

            $manager->persist($user);
        }


        $manager->flush(); // mettre à jour bdd
    }
}
