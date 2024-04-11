<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Cards\CardHand;
use App\Cards\DeckOfCards;

class QuoteControllerJson
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
    #[Route("/api")]
    public function jsonRoutes(): Response
    {
        $data = [
            'quote' => "/api/quote"
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote")]
    public function jsonNumber(): Response
    {
        $quotes = [
            '"The only true wisdom is in knowing you know nothing." - Socrates',
            '"In the end, it\'s not the years in your life that count. It\'s the life in your years." - Abraham Lincoln',
            '"The only way to do great work is to love what you do." - Steve Jobs'
        ];

        $dayOfYear = date('z');
        $quoteIndex = $dayOfYear % count($quotes);
        $quote = $quotes[$quoteIndex];

        $timestamp = time();
        $date = date('Y-m-d H:i:s', $timestamp);
        $data = [
            'timestamp' => $timestamp,
            'date' => $date,
            'quote' => $quote
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck")]
    public function deck(
        SessionInterface $session
    ): Response
    {
        $this->initSession($session);
        $deck = $session->get("deck");

        $deckData = $deck->getCards();
        $response = new JsonResponse($deckData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
