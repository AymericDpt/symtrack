<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;
    public function __construct(private SluggerInterface $slugger)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategorie('Informatique', null, $manager);

        $this->createCategorie('Ordinateurs portables', $parent, $manager);
        $this->createCategorie('Ecrans', $parent, $manager);
        $this->createCategorie('Souris', $parent, $manager);

        $parent = $this->createCategorie('Mode', null, $manager);

        $this->createCategorie('Hommes', $parent, $manager);
        $this->createCategorie('Femmes', $parent, $manager);
        $this->createCategorie('Enfants', $parent, $manager);

        $manager->flush();
    }

    public function createCategorie(string $nom, Categories $parent = null,
                                    ObjectManager $manager)
    {
        $categorie = new Categories();
        $categorie->setNom($nom);
        $categorie->setSlug($this->slugger->slug($categorie->getNom())->lower());
        $categorie->setParent($parent);
        $manager->persist($categorie);

        $this->addReference('cat-'.$this->counter, $categorie);
        $this->counter++;

        return $categorie;
    }
}
