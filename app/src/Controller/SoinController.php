<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SoinController extends AbstractController
{
    #[Route('/soin', name: 'app_soin')]
    public function index(): Response
    {
        return $this->render('soin/index.html.twig', [
            'controller_name' => 'SoinController',
        ]);
    }
}
