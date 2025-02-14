<?php

namespace App\Controller;
use App\Entity\Soin;
use App\Form\SoinType;
use App\Repository\SoinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SoinController extends AbstractController
{
    #[Route('/soin/new', name: 'soin_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $soin = new Soin();
        $form = $this->createForm(SoinType::class, $soin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($soin);
            $entityManager->flush();

            $this->addFlash('success', 'le soin a été ajoutée avec succès !');
        return $this->redirectToRoute('soin_list');
        }
        return $this->render('soin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/soin/list', name: 'soin_list')]
    public function list(SoinRepository $soinRepository): Response
    {
        $soins = $soinRepository->findAll();
        return $this->render('soin/soin_list.html.twig', [
            'soins' => $soins
        ]);
    }
    #[Route('/soin/edit/{id}', name: 'soin_edit')]
    public function edit($id, SoinRepository $soinRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $soin = $soinRepository->find($id);
        
        // Si le soin n'existe pas
        if (!$soin) {
            throw $this->createNotFoundException('Soin non trouvée');
        }

        $form = $this->createForm(SoinType::class, $soin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'soin modifiée avec succès !');

            return $this->redirectToRoute('soin_list');
        }

        return $this->render('soin/edit.html.twig', [
            'form' => $form->createView(),
            'soin' => $soin
        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function deleteSoin(EntityManagerInterface $entityManager, $id): Response
    {
        $soinSupprimer = $entityManager->getRepository(Soin::class)->find($id);
        $entityManager->remove($soinSupprimer);
        $entityManager->flush();
        /* return new Response("<h1>Le contact a bien ete supprime</h1>"); */
        return $this->redirectToRoute('soin_list');
    }


}