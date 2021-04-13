<?php

namespace App\Controller;

use App\Repository\HomePagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(HomePagesRepository $homePagesRepository): Response
    { 
        return $this->render('main/home.html.twig', [
            'posts' => $homePagesRepository->findAllDescById(),
        ]);
    }
    
        /**
     * @Route("/drumkit", name="drumkit")
     */
    public function drumkit(): Response
    {
        return $this->render('drumkit/drumkit.html.twig', [
        ]);
    }

    /**
     * @Route("/pierre", name="pierre")
     */
    public function pierre(): Response
    {
        return $this->render('main/pierre.html.twig', [
        ]);
    }
}
