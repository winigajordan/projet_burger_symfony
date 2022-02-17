<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ClientCommandeController extends AbstractController
{
    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */
    #[Route('/client/commande', name: 'client_commande')]
    public function index(CommandeRepository $cmd): Response
    {

       

       $commandes = $cmd -> findBy(["client"=>$this ->getUser()]);
       //dd($commandes);
        return $this->render('client_commande/index.html.twig', [
            'controller_name' => 'ClientCommandeController',
            'commandes' => $commandes
        ]);
    }

}
