<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrackmaniaController extends AbstractController
{
    /**
     * @Route("/trackmania", name="trackmania")
     */
    public function index(CategoryRepository $categoryRepository, MapRepository $mapRepository): Response
    {
        return $this->render('trackmania/list.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'maps' => $mapRepository->findAll(),
        ]);
    }
}
 