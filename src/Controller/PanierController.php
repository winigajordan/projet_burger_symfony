<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PanierController extends AbstractController
{

   
    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/panier', name: 'panier')]
    public function index( SessionInterface $session, ProduitRepository $productRepository): Response
    {

        $cart = $session->get('cart',[]);
        $cartItem=[];
        foreach ($cart as $id => $quantity) {
           
            $cartItem[]=[
                'produit' => $productRepository->find($id),
                'qte' => $quantity
            ];
        }

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'cartItem' => $cartItem
        ]);
    }

    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function addToCart($id, Request $request, SessionInterface $session){
        
        $panier = $session->get('cart',[]);
        
            if(!empty($panier[$id])){
                $panier[$id]++;
            }else{
                $panier[$id] = 1;
            }
        $session->set('cart', $panier);

        return $this-> redirectToRoute('panier');
    }


    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/panier/add/', name: 'panier_add_qte')]
    public function addWithQte(Request $request,  SessionInterface $session){
        $panier = $session->get('cart',[]);
        if ($request -> request -> get('qte')){
            $id = $request -> request -> get('id'); 
            $panier[$id]=intval($request -> request -> get('qte'));
        }
        $session->set('cart', $panier);
        return $this-> redirectToRoute('panier');
    }

    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/panier/update/', name: 'panier_update')]
    public function cartUpdate(Request $request, SessionInterface $session){
        //dd($request);
        $panier = $session->get('cart',[]);
        //dd($panier);
        foreach ($request->request as $id => $quantity) {
            $panier[$id]=intval($quantity);
            if($quantity <=0){
                unset($panier[$id]);
            }
           
        }
        $session->set('cart', $panier);
        return $this -> redirectToRoute('panier');
    }

    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    public function cancelCart(SessionInterface $session){

        $session->remove('cart');
    }

}
