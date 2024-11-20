<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Cards\GameTwentyOne;

class ApiGameController extends AbstractController
{
    /**
     * @Route("/api/game", name="api_twenty_one", methods={"GET"})
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/api/game", name: "api_twenty_one", methods: ['GET'])]
    public function twentyOne(SessionInterface $session): Response
    {
        /** @var GameTwentyOne $game */
        $game = $session->get("game");

        if (!$game instanceof GameTwentyOne) {
            $game = new GameTwentyOne();
            $session->set("game", $game);
        }

        $playerHand = array_map(fn ($card) => $card->getAsString(), $game->getPlayerHand());
        $dealerHand = array_map(fn ($card) => $card->getAsString(), $game->getDealerHand());

        $data = [
            "playerscore" => $game->getPlayerScore(),
            "playerhand" => $playerHand,
            "dealerscore" => $game->getDealerScore(),
            "dealerhand" => $dealerHand,
            "deckcount" => $game->getDeckCount(),
            "isgameover" => $game->isGameOver(),
            "winner" => $game->determineWinner(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }
}
