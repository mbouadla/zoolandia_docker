<?php

namespace App\Tests\Controller;

use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HabitatControllerTest extends KernelTestCase
{
    public function testIndexReturnsHabitats()
    {
        // Démarrage du noyau Symfony pour les tests
        self::bootKernel();

        // Récupération du container et du repository
        $container = static::getContainer();
        $habitatRepository = $container->get(HabitatRepository::class);

        // Vérification que le repository peut récupérer des données
        $habitats = $habitatRepository->findAll();
        $this->assertIsArray($habitats);
    }
}
