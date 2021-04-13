<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Map;
use App\Form\CategoryToDeleteType;
use App\Form\CategoryType;
use App\Form\MapToDeleteType;
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
     * @Route("", name="main")
     */
    public function main(CategoryRepository $categoryRepository, MapRepository $mapRepository): Response
    {
        $map = new Map();
        $mapForm = $this->createForm(MapType::class, $map);
        return $this->render('trackmania/main.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'maps' => $mapRepository->findAllWithStats(),
            'mapsOrdered' => $mapRepository->findAllWithStatsOrderedByName(),
        ]);
    }

    /**
     * @Route("/details", name="details")
     */
    public function details(): Response
    {
        return $this->render('trackmania/details.html.twig', [
        ]);
    }

    /**
    * @Route("/add", name="add")
    */
    public function add(Request $request): Response
    {
        $map = new Map();
        $category = new Category();
        $mapForm = $this->createForm(MapType::class, $map);
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $mapForm->handleRequest($request);
        $categoryForm->handleRequest($request);

        //On demande au formulaire s'il est valide, c'est-à-dire qu'on lui demande de vérifier qu'il n'y a aucune erreur dedans
        if ($mapForm->isSubmitted() && $mapForm->isValid()) {
            //Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            //On peut persister $map
            //dd($mapForm);

            $em = $this->getDoctrine()->getManager();
            $em->persist($map);
            $em->flush();

            //Quand on a fini, on redirige l'utilisateur sur la même page mais en GET
            return $this->redirectToRoute('trackmania_main');
        }

        //On demande au formulaire s'il est valide, c'est-à-dire qu'on lui demande de vérifier qu'il n'y a aucune erreur dedans
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            //Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            //On peut persister $category
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            //Quand on a fini, on redirige l'utilisateur sur la même page mais en GET
            return $this->redirectToRoute('trackmania_main');
        }

        return $this->render('trackmania/add.html.twig', [
            'mapForm' => $mapForm->createView(), //FormView
            'categoryForm' => $categoryForm->createView(), //FormView
        ]);
    }

    /**
    * @Route("/delete", name="delete")
    */
    public function delete(Request $request,CategoryRepository $categoryRepository, MapRepository $mapRepository): Response
    {
        $mapForm = $this->createForm(MapToDeleteType::class);
        $categoryForm = $this->createForm(CategoryToDeleteType::class);
        $mapForm->handleRequest($request);
        $categoryForm->handleRequest($request);

        //On demande au formulaire s'il est valide, c'est-à-dire qu'on lui demande de vérifier qu'il n'y a aucune erreur dedans
        if ($mapForm->isSubmitted() && $mapForm->isValid()) {
            //Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            //On peut persister $map
            $map = $mapRepository->find($mapForm['name']->getData()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->remove($map);
            $em->flush();

            //Quand on a fini, on redirige l'utilisateur sur la même page mais en GET
            return $this->redirectToRoute('trackmania_main');
        }

        //On demande au formulaire s'il est valide, c'est-à-dire qu'on lui demande de vérifier qu'il n'y a aucune erreur dedans
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            //Ici on est dans le cas où le formulaire est envoyé et valide (valide : tous les champs sont «correctes»)
            //On peut persister $category
            $category = $categoryRepository->find($categoryForm['name']->getData()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            //Quand on a fini, on redirige l'utilisateur sur la même page mais en GET
            return $this->redirectToRoute('trackmania_main');
        }

        return $this->render('trackmania/delete.html.twig', [
            'mapForm' => $mapForm->createView(), //FormView
            'categoryForm' => $categoryForm->createView(), //FormView
        ]);
    }
}
 