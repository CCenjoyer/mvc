<?php

namespace App\Controller;

use App\Cards\CardHand;
use App\Cards\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Exception;

class CardsController extends AbstractController
{
    /**
     * Initialize the session with a deck and hand if they don't exist
     * @param SessionInterface $session
     * @return void
     */
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

    /**
     * @Route("/card/init", name="card_init")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/init", name: "card_init")]
    public function init(
        SessionInterface $session
    ): Response {
        $hand = new CardHand();
        $deck = new DeckOfCards();
        $deck->makeDeck();
        $session->set("hand", $hand);
        $session->set("deck", $deck);
        return $this->redirectToRoute('card');
    }

    /**
     * @Route("/card", name="card")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card", name: "card")]
    public function card(
        SessionInterface $session
    ): Response {
        $this->initSession($session);
        /** @var CardHand $hand */
        $hand = $session->get("hand");
        $cards = $hand->getCards();
        $data = [
            "cards" => $cards
        ];
        return $this->render('cards/card.html.twig', $data);
    }


    /**
     * @Route("/card/deck", name="deck")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/deck", name: "deck", methods: ['GET'])]
    public function deck(
        SessionInterface $session
    ): Response {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        $sortedDeck = clone $deck;
        $sortedDeck->sort();
        $cards = $sortedDeck->getCards();
        $data = [
            "cards" => $cards
        ];
        return $this->render('cards/deck.html.twig', $data);
    }


    /**
     * @Route("/card/deck/sort", name="sort")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/deck/shuffle", name: "shuffle", methods: ['GET'])]
    public function shuffle(
        SessionInterface $session
    ): Response {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        $deck->shuffle();
        $cards = $deck->getCards();
        $data = [
            "cards" => $cards
        ];
        return $this->render('cards/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw", name="draw")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/deck/draw", name: "draw", methods: ['GET'])]
    public function draw(
        SessionInterface $session
    ): Response {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        /** @var CardHand $hand */
        $hand = $session->get("hand");
        if ($deck->getCards() != []) {
            $card = $deck->drawCard();
            $hand->addCard($card);
            $cardCount = $deck->cardCount();
            $session->set("hand", $hand);
            $session->set("deck", $deck);
            $data = [
                "card" => $card,
                "deckCardCount" => $cardCount
            ];
            return $this->render('cards/draw.html.twig', $data);
        }
        $this->addFlash(
            'notice',
            'Out of Cards!'
        );
        return $this->redirectToRoute('card');
    }

    /**
     * @Route("/card/deck/draw/{num<\d+>}", name="drawX")
     * @param int $num
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/card/deck/draw/{num<\d+>}", name: "drawX")]
    public function multipleDraw(
        int $num,
        SessionInterface $session
    ): Response {
        $this->initSession($session);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        /** @var CardHand $hand */
        $hand = $session->get("hand");

        if ($deck->getCards() == []) {
            $this->addFlash('notice', 'Out of Cards!');
            return $this->redirectToRoute('card');
        }

        $num = min($num, $deck->cardCount());
        $allDrawnCards = [];

        for ($i = 0; $i < $num; $i++) {
            $card = $deck->drawCard();
            $hand->addCard($card);
            $allDrawnCards[] = $card;
        }

        $session->set("hand", $hand);
        $session->set("deck", $deck);

        $data = [
            "cards" => $allDrawnCards,
            "deckCardCount" => $deck->cardCount()
        ];

        return $this->render('cards/drawX.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw-form", name="draw_form")
     * @param Request $request
     * @return Response
     */
    #[Route("/card/deck/draw-form", name: "draw_form")]
    public function drawForm(
        Request $request
    ): Response {
        $numCards = $request->request->get('num');
        return $this->redirectToRoute('drawX', ['num' => $numCards]);
    }

    #[Route("/card/doc", name: "card_docs")]
    public function cardDocs(): Response
    {
        return $this->render('cards/carddoc.html.twig');
    }
}
