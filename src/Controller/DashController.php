<?php

namespace App\Controller;

use DateTime;
use DateTimeImmutable;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use function PHPUnit\Framework\isEmpty;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetailCommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashController extends AbstractController
{

    
    

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/dash', name: 'dash')]
    public function index(CommandeRepository $cmdRp): Response
    {
        

        

        
        //dd($date);
        $commandes = $cmdRp -> findAll();
        $commandesAttente = $cmdRp -> findBy(['statut'=>'En attente']);
        $commandePaye = $cmdRp -> findBy(['statut'=>'Payé']);
        


        return $this->render('dash/index.html.twig', [
            'controller_name' => 'DashController',
            'commandes' => $commandes,
            'en_attente' => count($commandesAttente),
            'paye' => count($commandePaye),
            
        ]);
    }

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/dash/commande/{id}', name: 'dash_cmd_details')]
    public function showDetailCommandes($id, DetailCommandeRepository $dcr, CommandeRepository $cmdRp, ClientRepository $cl){
        $commandes = $cmdRp -> findAll();
        $cmd = $cmdRp->find(intval($id));
        $dtl= $dcr -> findBy(['commande'=>$cmd]);
        $client = $cl -> find($cmd -> getClient() -> getId());


        $date = new DateTimeImmutable();
        $commandes = $cmdRp -> findAll();
        $commandesAttente = $cmdRp -> findBy(['statut'=>'En attente']);
        $commandePaye = $cmdRp -> findBy(['statut'=>'Payé', 'createdAt' => $date]);
        $recette = 0;
        foreach($commandePaye as $cmd){
            $recette = $recette + $cmd -> getTotal();
        }
        
        return $this->render('dash/index.html.twig', [
            'controller_name' => 'DashController',
            'commandes' => $commandes,
            'details' => $dtl,
            'commande' => $cmd,
            'client' => $client,
            'en_attente' => count($commandesAttente),
            'paye' => count($commandePaye),
            'recette' => $recette
        ]);
        //dd( $cartItem);


    }

    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/dash/commande/', name: 'dash_cmd_update')]
    public function updateCommande(CommandeRepository $cmdRp, Request $request, CommandeRepository $ripo, EntityManagerInterface $em){
        //dd($request);
        $statut = $request -> request-> get('status');
        $commandes = $cmdRp -> findAll();
        if(isEmpty($statut)){
            $id = intval($request -> request-> get('id'));
            $commande = $ripo -> find($id);
            $commande -> setStatut($statut);
            $em -> persist($commande);
            $em -> flush();

        }
        
        return $this->redirectToRoute('dash');

    }

}
