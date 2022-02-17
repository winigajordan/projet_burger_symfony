<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $categorie = new Categorie();
        $categorie -> setNom('Boissons');
        $categorie -> setImage('image boisson');
        $categorie -> setSlug('categorie-boisson');
        $manager -> persist($categorie);
        
        $categorie1 = new Categorie();
        $categorie1 -> setNom('Sauces');
        $categorie1 -> setImage('image sauces');
        $categorie1 -> setSlug('categorie-sauce');
        $manager -> persist($categorie1);
        
        $manager->flush();
    }
}
