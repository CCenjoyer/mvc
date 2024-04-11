<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Cards\CardHand;
use App\Cards\DeckOfCards;

class JsonApiController
{
    private function initSession(
        SessionInterface $session
        ): void
    {
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
    public function deck(
        SessionInterface $session
    ): Response
    {
        $this->initSession($session);
        $deck = $session->get("deck");
        if ($deck) {
            $deckClone = clone $deck;
            $cardsData = [];
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
        } else {
            return new JsonResponse(['error' => 'Deck not found in session'], Response::HTTP_NOT_FOUND);
        }
    }


    #[Route("/api/shuffle", name: "shuffle")]
    public function shuffle(
        SessionInterface $session
        ): Response
    {
        $this->initSession($session);
        $deck = $session->get("deck");
        if ($deck) {
            $deck->shuffle();
            $cardsData = [];
            foreach ($deck->getCards() as $card) {
                $cardsData[] = $card->getAsString();
            }
            $deckData = [
                'cards' => $cardsData,
                'count' => $deck->cardCount()
            ];
            $session->set("deck", $deck);
            $response = new JsonResponse($deckData);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        } else {
            return new JsonResponse(['error' => 'Deck not found in session'], Response::HTTP_NOT_FOUND);
        }
    }

}
