<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     *
     * @IsGranted("ROLE_CLIENT")
     */ 
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.dashboard.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
