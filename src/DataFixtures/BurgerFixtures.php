<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Burger;

class BurgerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=1; $i<=5; $i++ ){
            $burger = new Burger();
            $burger -> setNom('Burger'.$i);
            $burger -> setPrix(100+$i);
            $burger -> setImage('image burger '.$i);
            $burger -> setDescription('Description du burger '.$i);
            $manager -> persist($burger);
        }

        $manager->flush();
    }
}
