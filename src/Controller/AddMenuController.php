<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AddMenuController extends AbstractController
{
    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/add/menu', name: 'add_menu')]
    public function index(MenuRepository $menuRp): Response
    {
        $menus = $menuRp->findAll();
        return $this->render('add_menu/index.html.twig', [
            'menus' => $menus,

        ]);
    }


    /**
     *
     * @IsGranted("ROLE_GESTIONNAIRE")
     */ 
    #[Route('/add/menu/save', name: 'menu_save')]
    public function addMenu(Request $request, EntityManagerInterface $manager): Response
    {
       //dd($request);
       $menu = new Menu();

       $menu -> setNom($request->request->get('nom'));
       $menu -> setPrix($request->request->get('prix'));
       $menu -> setDescription($request->request->get('description'));
       $menu -> setImage($request->request->get('image'));

       $manager->persist($menu);
       $manager->flush();

       //   dd('Enregistrement effectue'); 

       return $this->redirectToRoute("/add/menu");
    }

}
