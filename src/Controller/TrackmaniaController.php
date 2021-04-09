<?php

namespace App\Controller;

use App\Entity\Map;
use App\Form\MapType;
use App\Repository\CategoryRepository;
use App\Repository\MapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trackmania", name="trackmania_")
 */
class TrackmaniaController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(CategoryRepository $categoryRepository, MapRepository $mapRepository): Response
    {
        return $this->render('trackmania/list.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'maps' => $mapRepository->findAllWithStats(),
            'mapsOrdered' => $mapRepository->findAllWithStatsOrderedByName(),
        ]);
    }

        /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        // On crée un objet Map vide, son constructeur prérempli la propriété $createdAt
        $map = new Map();

        // On crée un objet $form à partir du modèle de formulaire décrit dans MapType
        // On associe le formulaire à $map pour que les changements dans $map apparaisse dans le formulaire et inversement
        $form = $this->createForm(MapType::class);
        // On demande au formulaire d'analyser la requète et d'en retirer
        // les informations reçues en POST, s'il les trouve il remplit les informations dans $movie
        $form->handleRequest($request);
        //dd($form);
        // À ce stade, si on a reçu des données en POST et qu'elles sont bonnes :
        // $movie est prérempli, on peut le persister et le flush
        // $form a une propriété submitted qui veut maintenant «true»

        // On demande au formulaire s'il est valide, c'est-à-dire qu'on lui demande de vérifier qu'il n'y a aucune erreur dedans
        //if ($form->isSubmitted() && $form->isValid()) {
            // Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            // On peut persister $movie
        //    $em = $this->getDoctrine()->getManager();
        //    $em->persist($movie);
        //    $em->flush();

            // Quand on a fini, on redirige l'utilisateur sur la même page mais en GET
        //    return $this->redirectToRoute('trackmania_list');
        //}

        return $this->render('trackmania/add.html.twig', [
            'form' => $form->createView(), //FormView
        ]);
    }  
}
 