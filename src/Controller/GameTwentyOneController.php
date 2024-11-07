<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\CardHand;
use App\Cards\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameTwentyOneController extends AbstractController
{
    private function initSession(SessionInterface $session): void {
        if (!$session->has("hand")) {
            $session->set("hand", new CardHand());
        }
        if (!$session->has("deck")) {
            $deck = new DeckOfCards();
            $deck->makeDeck();
            $session->set("deck", $deck);
        }
    }

    #[Route("/game", name: "game")]
    public function showSession(
        SessionInterface $session
    ): Response {
        $this->initSession($session);

        $data = [
            'session' => $session->all()
        ];

        return $this->render('session.html.twig', $data);
    }
}
