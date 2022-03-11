<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProductsFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $faker = Factory::create('fr__FR');

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setName($faker->words(3, true))
                ->setDescription($faker->paragraph(2))
                ->setPrice($faker->numberBetween(0, 20000))
                ->setSlug($faker->slug(2))
                ->setSubtitle($faker->words(3, true))
                ->setIllustration($faker->image('public/uploads', 360, 360, 'PRODUCT', false, true, 'cats', true))
                ->setCategory($this->getReference('categorie_' . $faker->numberBetween(1, 10)));


            $manager->persist($product);
        }


        $manager->flush(); // mettre à jour bdd
    }
}
