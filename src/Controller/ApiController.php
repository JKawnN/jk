<?php

namespace App\Controller;

use App\Repository\MapRepository;
use App\Repository\UserRepository;
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
        return $this->json($mapRepository->findAll(), 200, [], ['groups' => 'map:read']);
    }

    /**
     * @Route("users", name="users_list", methods={"GET"})
     */
    public function users(UserRepository $userRepository)
    {
        return $this->json($userRepository->findAll(), 200, [], ['groups' => 'user:read']);
    }
}
