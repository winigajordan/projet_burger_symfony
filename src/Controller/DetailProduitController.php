<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Entity\Menu;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DetailProduitController extends AbstractController
{
    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/detail/produit/{id}', name: 'detail_produit')]
    public function index($id, ProduitRepository $rp, SessionInterface $session): Response
    {

        $produit = $rp -> find(intval($id));
        $cart = $session->get('cart',[]);
        //dd($produit);
        $qte = 0;
        foreach ($cart as $idc => $quantity) {
           if($idc==$id){
                $qte = $quantity;
           }
        }
            
            return $this->render('detail_produit/index.html.twig', [
                'controller_name' => 'DetailProduitController',
                'produitSelectionne' => $produit,
                'qteSelectionne' => $qte
            ]);
        
       
    }
}
