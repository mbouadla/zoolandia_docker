<?php

// src/Controller/ObservationController.php

namespace App\Controller;

use App\Entity\Observation;
use App\Form\ObservationType;
use App\Repository\ObservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObservationController extends AbstractController
{
    #[Route('/observation/new', name: 'observation_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($observation);
            $entityManager->flush();

            $this->addFlash('success', 'Observation ajoutée avec succès !');

            return $this->redirectToRoute('observation_list');
        }

        return $this->render('observation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/observation/list', name: 'observation_list')]
    public function list(ObservationRepository $observationRepository): Response
    {
        $observations = $observationRepository->findAll();
        return $this->render('observation/observation_list.html.twig', [
            'observations' => $observations
        ]);
    }

    #[Route('/observation/edit/{id}', name: 'observation_edit')]
    public function edit($id, ObservationRepository $observationRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $observation = $observationRepository->find($id);
        
        // Si l'observation n'existe pas
        if (!$observation) {
            throw $this->createNotFoundException('Observation non trouvée');
        }

        $form = $this->createForm(ObservationType::class, $observation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Observation modifiée avec succès !');

            return $this->redirectToRoute('observation_list');
        }

        return $this->render('observation/edit.html.twig', [
            'form' => $form->createView(),
            'observation' => $observation
        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function deleteObservation(EntityManagerInterface $entityManager, $id): Response
    {
        $observationSupprimer = $entityManager->getRepository(Observation::class)->find($id);
        $entityManager->remove($observationSupprimer);
        $entityManager->flush();
        /* return new Response("<h1>Le contact a bien ete supprime</h1>"); */
        return $this->redirectToRoute('observation_list');
    }
}
