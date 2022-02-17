<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Menu;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i <= 5; $i++){
            $menu = new Menu();
            $menu -> setNom('Menu'.$i);
            $menu -> setPrix(100+$i);
            $menu -> setImage('image menu '.$i);
            $menu -> setDescription('Description du Menu '.$i);
            $manager -> persist($menu);
        }

        $manager->flush();
    }
}
