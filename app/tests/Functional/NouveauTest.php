<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NouveauTest extends WebTestCase
{
    public function testPageAccueilAccessible()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful(); // Vérifie que la page d'accueil est accessible
        $this->assertSelectorExists('h1'); // Vérifie qu'un titre H1 est présent
    }
}
