<?php
namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function stripe(): Response
    {
        return $this->render('stripe/checkout.html.twig');
    }

    #[Route('/checkout', name: 'app_checkout', methods: ['POST'])]
    public function checkout(Request $request): RedirectResponse
    {
        // Clé secrète Stripe
        Stripe::setApiKey('sk_test_51QuCrUF4493wOuXy6DnbX0FOq4CGWg3rLw3TQ8gOs4qzaS4qWB89xfI8RhxkKXgV1cu847fJ4X7kDmqijl17mlGe00W6fi39n1'); 

        // Récupération des quantités de billets
        $billetEnfant = $request->request->getInt('billet_enfant', 0);
        $billetAdulte = $request->request->getInt('billet_adulte', 0);

        // Création des éléments de paiement
        $lineItems = [];

        if ($billetEnfant > 0) {
            $lineItems[] = [
                'price' => 'price_1QubMxF4493wOuXyokqURjq4',
                'quantity' => $billetEnfant,
            ];
        }
        if ($billetAdulte > 0) {
            $lineItems[] = [
                'price' => 'price_1QubNEF4493wOuXywZOQI3tE',
                'quantity' => $billetAdulte,
            ];
        }

        // Si aucun billet n'a été sélectionné, retour à la page d'accueil
        if (empty($lineItems)) {
            return $this->redirectToRoute('app_stripe');
        }

        // Création de la session de paiement Stripe
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_success', [], 0),
            'cancel_url' => $this->generateUrl('app_stripe', [], 0),
        ]);

        return new RedirectResponse($session->url, 303);
    }

    #[Route('/success', name: 'app_success')]
    public function success(): Response
    {
        return $this->render('stripe/success.html.twig');
    }
    #[Route('/', name: 'app_main')]  // Définir la route app_main sur la page d'accueil
    public function index()
    {
        // Retourne le template de la page d'accueil
        return $this->render('home/index.html.twig');
    }
}

