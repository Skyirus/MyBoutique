<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        for ($i = 1; $i < 11; $i++) {
            $category = new Category();
            $category->setName('Cat-' . $i);

            $this->addReference('categorie_' . $i, $category);

            $manager->persist($category); // ajouter à la memoire 
        }

        $manager->flush(); // mettre à jour bdd
    }
}
