<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Animaux;
use App\Repository\HabitatRepository;
use App\Entity\Habitat;
use App\Repository\AnimauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HabitatController extends AbstractController
{
    #[Route('/habitat', name: 'app_habitat')]
    public function index(HabitatRepository $habitatsrepository): Response
    {
        $habitats = $habitatsrepository->findAll();
        return $this->render('habitat/index.html.twig', [
            'habitats' => $habitats
        ]);
    }

    #[Route('/habitat/{id}', name: 'app_list_animaux')]
    public function showListesAnimaux(EntityManagerInterface $entityManager, $id, AnimauxRepository $animauxRepository ): Response
    {
        $habitat = $entityManager->getRepository(Habitat::class)->find($id);
        $animaux = $animauxRepository->findBy(['habitat' => $habitat]);
        
        return $this->render('list_animaux.html.twig', [
            'habitat' => $habitat,
            'animaux' => $animaux
        ]);
    }

    #[Route('/animal/{id}', name: 'app_animal')]
    public function showAnimal(EntityManagerInterface $entityManager, $id): Response
    {
        $animal = $entityManager->getRepository(Animaux::class)->find($id);
        return $this->render('details_animaux.html.twig', [
            'animal' => $animal,
        ]);
    }      
}
