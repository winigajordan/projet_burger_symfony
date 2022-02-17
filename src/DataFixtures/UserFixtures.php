<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $password = '1234';
        for ($i=1; $i<=5; $i++){
            $x = rand(0,1);
            $user = new Client();
            $user -> setEmail('client'.$i.'@gmail.com');
            $user -> setRoles(['ROLE_CLIENT']);
            $user-> setNom('nom'.$i);

            $user -> setPrenom('prenom'.$i);

            $mdp = $this->hasher->hashPassword($user, $password);


            $user->setPassword($mdp);
            $manager -> persist($user);
        }


        $password = 'Azerty90@';
        for ($i=1; $i<=5; $i++){
            $x = rand(0,1);
            $user = new Gestionnaire();
            $user -> setEmail('gestionnaire'.$i.'@gmail.com');
            $user -> setRoles(['ROLE_GESTIONNAIRE', 'ROLE_CLIENT']);
            $user-> setNom('nomGest '.$i);

            $user -> setPrenom('prenom'.$i);

            $mdp = $this->hasher->hashPassword($user, $password);


            $user->setPassword($mdp);
            $manager -> persist($user);
        }


        $manager->flush();
    }
}
