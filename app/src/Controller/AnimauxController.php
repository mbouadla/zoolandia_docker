<?php

namespace App\Controller;
use App\Repository\AnimauxRepository;
use App\Form\AnimauxType;
use App\Entity\Animaux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnimauxController extends AbstractController
{
    #[Route('/animaux/{id}', name: 'app_animaux')]
    public function index(AnimauxRepository $AnimauxRepository): Response
    {   $animaux = $AnimauxRepository->findAll();
        return $this->render('animaux/index.html.twig', [
            'animaux' => $animaux
        ]);
    }
    #[Route('/animal/new', name: 'animal_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animaux(); // Assure-toi que tu initialises correctement l'objet
        $form = $this->createForm(AnimauxType::class, $animal);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animal);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_list_animaux', ['id' => $animal->getHabitat()->getId()]);
 // Redirige vers la liste des animaux par exemple
        }
    
        return $this->render('ajouterAnimaux.html.twig', [
            'formulaire' => $form->createView(),
            'animal' => $animal, // Assure-toi de passer l'objet animal
        ]);
    }
    
    #[Route('/animal/{id}/edit', name: 'animal_edit')]
public function edit(Request $request, EntityManagerInterface $entityManager, $id): Response
{
    $animal = $entityManager->getRepository(Animaux::class)->find($id);

    if (!$animal) {
        throw $this->createNotFoundException("L'animal avec l'ID $id n'existe pas.");
    }

    $formulaire = $this->createForm(AnimauxType::class, $animal);
    $formulaire->handleRequest($request);

    if ($formulaire->isSubmitted() && $formulaire->isValid()) {
        $entityManager->flush();

        $this->addFlash('notice_success', 'Animal modifié avec succès!');

        // Redirection vers la liste des animaux, en passant l'ID de l'habitat
        return $this->redirectToRoute('app_list_animaux', ['id' => $animal->getHabitat()->getId()]);
    }

    return $this->render("ajouterAnimaux.html.twig", [
        "formulaire" => $formulaire->createView(),
        "animal" => $animal,
    ]);
}


    
#[Route('/animal/{id}/delete', name: 'animal_delete', methods: ['POST', 'GET'])]
public function delete(EntityManagerInterface $entityManager, $id): Response
{
    $animal = $entityManager->getRepository(Animaux::class)->find($id);

    if (!$animal) {
        throw $this->createNotFoundException("L'animal avec l'ID $id n'existe pas.");
    }

    $habitatId = $animal->getHabitat()->getId(); // Récupération de l'ID de l'habitat

    $entityManager->remove($animal);
    $entityManager->flush();

    $this->addFlash('notice_success', 'Animal supprimé avec succès!');

    // Redirection vers la liste des animaux de l'habitat
    return $this->redirectToRoute('app_list_animaux', ['id' => $habitatId]);
}

    
}
