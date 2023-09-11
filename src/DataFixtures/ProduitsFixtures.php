<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProduitsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        for ($prod = 1; $prod <=10; $prod++){
            $produit = new Produits();
            $produit->setNom($faker->text(15));
            $produit->getDescription($faker->text());
            $produit->setSlug($this->slugger->slug($produit->getNom())->lower());
            $produit->setPrix($faker->numberBetween(100, 300000));
            $produit->setStock($faker->numberBetween(0, 20));

            $categorie = $this->getReference('cat-'.rand(1, 8));
            $produit->setCategories($categorie);

            $manager->persist($produit);
        }

        $manager->flush();
    }
}
