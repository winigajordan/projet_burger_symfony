<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AcceuilController extends AbstractController
{
    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/acceuil', name: 'acceuil')]
    public function index(BurgerRepository $ripo, MenuRepository $menuRp, ComplementRepository $comp ): Response
    {
        $burgers = $ripo -> findAll();
        $menus = $menuRp -> findAll();
        $complements = $comp -> findAll();
        return $this->render('acceuil/index.html.twig', [
            'burgers' => $burgers,
            'menus' => $menus,
            'complements' => $complements
        ]);
    }



}
