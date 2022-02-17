<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Complement;
use App\Repository\CategorieRepository;
use App\Repository\ComplementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ComplementController extends AbstractController
{
    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/complement', name: 'complement')]
    public function index(CategorieRepository $cat, ComplementRepository $com): Response
    {
        $complements = $com-> findAll();
        $categories = $cat ->findAll();

        return $this->render('complement/index.html.twig', [
            'controller_name' => 'ComplementController',
            'categories' => $categories,
            'complements' => $complements
        ]);
    }

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/complement/save', name: 'complement_save')]
    public function save(Request $request, EntityManagerInterface $manager, CategorieRepository $ripo)
    {
        //dd($request);
        $categorie = $ripo -> find( intval($request->request->get('categorie')));
        $complement = new Complement();
        $complement -> setNom($request->request->get('nom'));  
        $complement -> setPrix($request->request->get('prix'));  
        $complement -> setImage($request->request->get('image'));  
        $complement -> setCategorie($categorie);
        $manager -> persist($complement);
        $manager -> flush();
        return $this->redirectToRoute("complement");    
    }


    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/complement/update/{id}', name: 'complement_update')]
    public function update($id, CategorieRepository $cat, ComplementRepository $com){
        //dd($id);

            $complements = $com-> findAll();
            $categories = $cat ->findAll();
            $complementSelected = $com -> find(intval($id));

            return $this->render('complement/index.html.twig', [
                'controller_name' => 'ComplementController',
                'categories' => $categories,
                'complements' => $complements,
                'ComplementSelected' => $complementSelected
            ]);
    

    }

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/complement/edit/', name: 'complement_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, ComplementRepository $ripo,  CategorieRepository $ct){

        $categorie = $ct -> find( intval($request->request->get('categorie')));

        $complement = $ripo->find($request->request->get('id'));
        
        $complement -> setNom($request->request->get('nom'));
        $complement -> setPrix($request->request->get('prix'));
        $complement -> setImage($request->request->get('image'));
        $complement -> setCategorie($categorie);
        $manager->persist($complement);
        $manager->flush();

        //dd('Enregistrement effectue');

        return $this->redirectToRoute("complement");

    }



}
