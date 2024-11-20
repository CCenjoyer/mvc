<?php

namespace App\Controller;

use App\Cards\CardHand;
use App\Cards\DeckOfCards;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiCardsController extends AbstractController
{
    private function initSession(
        SessionInterface $session
    ): void {
        if (!$session->has("hand")) {
            $session->set("hand", new CardHand());
        }
        if (!$session->has("deck")) {
            $deck = new DeckOfCards();
            $deck->makeDeck();
            $session->set("deck", $deck);
        }
    }

    #[Route("/api/deck", name: "api_deck")]
    public function deck(SessionInterface $session): Response
    {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        $deckClone = clone $deck;
        $cardsData = [];
        $deckClone->sort();

        foreach ($deckClone->getCards() as $card) {
            $cardsData[] = $card->getAsString();
        }

        $deckData = [
            'cards' => $cardsData,
            'count' => $deckClone->cardCount()
        ];
        $response = new JsonResponse($deckData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle", methods: ['POST'])]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        if ($deck->cardCount() == 0) {
            $deck = new DeckOfCards();
            $deck->makeDeck();
        }
        $deck->shuffle();
        $session->set("deck", $deck);
        $cardsData = [];

        foreach ($deck->getCards() as $card) {
            $cardsData[] = $card->getAsString();
        }

        /** @var DeckOfCards $deck */
        $deckData = [
            'cards' => $cardsData,
            'count' => $deck->cardCount()
        ];

        $response = new JsonResponse($deckData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw", name: "api_draw", methods: ['POST'])]
    public function draw(SessionInterface $session): Response
    {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        /** @var CardHand $hand */
        $hand = $session->get("hand");

        $card = $deck->drawCard();
        $hand->addCard($card);
        $session->set("deck", $deck);
        $session->set("hand", $hand);
        $data = [
            "card" => $card->getAsString(),
            "deckCardCount" => $deck->cardCount()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw-form", name: "draw_x_form", methods: ['POST'])]
    public function drawXForm(Request $request): Response
    {
        $numCards = $request->request->getInt('num');
        return $this->redirectToRoute('api_draw_x', ['num' => $numCards]);
    }


    #[Route("/api/deck/draw/{num<\d+>}", name: "api_draw_x", methods: ['GET'])]
    public function drawX(int $num, SessionInterface $session): Response
    {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        /** @var CardHand $hand */
        $hand = $session->get("hand");

        $drawnCards = [];
        for ($i = 0; $i < $num; $i++) {
            try {
                $card = $deck->drawCard();
            } catch (\Exception) {
                break;
            }

            $hand->addCard($card);
            $drawnCards[] = $card->getAsString();
        }
        $session->set("deck", $deck);
        $session->set("hand", $hand);
        $data = [
            "cards" => $drawnCards,
            "deckCardCount" => $deck->cardCount()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }
}
