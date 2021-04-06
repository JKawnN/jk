<?php

namespace App\Controller;

use App\Repository\MapRepository;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("trackmania/maps", name="trackmania_maps_list", methods={"GET"})
     */
    public function trackmania_maps(MapRepository $mapRepository)
    {
        $mapRepository->findAllWithStats();
        return $this->json($mapRepository->findAllWithStats(), 200, [], ['groups' => 'map:read']);
    }

    /**
     * @Route("players", name="players_list", methods={"GET"})
     */
    public function players(PlayerRepository $playerRepository)
    {
        return $this->json($playerRepository->findAll(), 200, [], ['groups' => 'player:read']);
    }
}
