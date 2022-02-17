<?php

namespace App\Controller;

use App\Entity\Client;
use DateTime;
use DateTimeImmutable;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    public function getFullCart(SessionInterface $session,ProduitRepository $productRepository): array
    {
        $cart = $session->get('cart',[]);
        $cartItem=[];
        foreach ($cart as $id => $quantity) {
           
            $cartItem[]=[
                'item' => $productRepository->find($id),
                'qte' => $quantity
            ];
        }

        return $cartItem;
    }

    public function getTotal(SessionInterface $session,ProduitRepository $productRepository): float
    {
        $panierWithData = $this->getFullCart($session, $productRepository);

        $total = 0;

        foreach ($panierWithData as $couple) {
            $total += $couple['item']->getPrix() * $couple['qte'];
        }

        return $total;
    }

    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */
    #[Route('/commande/add', name: 'commande_add')]
    public function addCommande(SessionInterface $session, ProduitRepository $productRepository, ClientRepository $cl, EntityManagerInterface $em){

        


        $commande = new Commande();
        $commande -> setReference(uniqid());
        $commande -> setCreatedAt(new DateTimeImmutable());
        $commande -> setUpdatedAt(new DateTime());
        $commande -> setStatut('En attente');
        $commande -> setIsPaid(false);
        $commande -> setTotal($this->getTotal($session, $productRepository));
        $commande -> setClient($this->getUser());
       
        
        $em ->persist($commande);

        $produitsPanier = $this -> getFullCart($session, $productRepository);
        foreach($produitsPanier as $prod){
            $detailCommande = new DetailCommande ();
            $detailCommande -> setQuantite($prod['qte']);
            $detailCommande -> setCommande($commande);
            $detailCommande -> setProduit($prod['item']);
            $detailCommande -> setTotal($prod['qte'] * $prod['item']->getPrix() );

            $em -> persist($detailCommande);
            $commande -> addDetailCommande($detailCommande);
        }

        $em ->persist($commande);
        $em -> flush();

        $session->set('cart', []);
        return $this->redirectToRoute('client_commande');



    }
}
