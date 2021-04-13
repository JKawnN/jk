<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/riot", name="riot_")
 */
class RiotController extends AbstractController
{
    /**
     * @Route("/details", name="details")
     */
    public function details(): Response
    {
        return $this->render('riot/details.html.twig', [
            
        ]);
    }
    /**
     * @Route("", name="main")
     */
    public function main(): Response
    {
        return $this->render('riot/main.html.twig', [

        ]);
    }
}
