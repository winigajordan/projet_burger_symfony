<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BurgerController extends AbstractController
{


    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/burger', name: 'burger')]
    public function index(BurgerRepository $ripo ): Response
    {
        $burgers = $ripo -> findAll();

        return $this->render('burger/index.html.twig', [
            'burgers' => $burgers,
        ]);

    }

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/burger/save', name: 'burger_save')]
    public function save(Request $request, EntityManagerInterface $manager)
    {
        //dd($request);
        $burger = new Burger();

        $burger -> setNom($request->request->get('nom'));
        $burger -> setPrix($request->request->get('prix'));
        $burger -> setDescription($request->request->get('description'));
        $burger -> setImage($request->request->get('image'));

        $manager->persist($burger);
        $manager->flush();

        //dd('Enregistrement effectue');

        return $this->redirectToRoute("burger");
        
    }

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/burger/update/{id?}', name: 'burger_update')]
    public function update(Burger $burger,BurgerRepository $ripo ){

        

        $burgers = $ripo -> findAll();

        return $this->render('burger/index.html.twig', [
            'burgers' => $burgers,
            'burgerSelect' => $burger
        ]);

    }




    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/burger/edit/', name: 'burger_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, BurgerRepository $ripo){

        $burger = $ripo->find($request->request->get('id'));
        $burger -> setNom($request->request->get('nom'));
        $burger -> setPrix($request->request->get('prix'));
        $burger -> setDescription($request->request->get('description'));
        $burger -> setImage($request->request->get('image'));

        $manager->persist($burger);
        $manager->flush();

        //dd('Enregistrement effectue');

        return $this->redirectToRoute("burger");

    }

    

    
}
