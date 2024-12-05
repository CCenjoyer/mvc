<?php

namespace App\Controller;

use App\Cards\BlackJack;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiBlackJackController extends AbstractController
{
    /**
     * Initialize the session with a deck and hand if they don't exist
     * @param SessionInterface $session
     * @return void
     */
    private function initSession(
        SessionInterface $session
    ): void {
        if (!$session->has("game")) {
            $game = new BlackJack();
            $session->set("game", $game);
        }
    }

    /**
     * @Route("/proj/api/blackjack", name: "api_blackjack_index")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/proj/api/blackjack", name: "api_blackjack_index")]
    public function index(SessionInterface $session): Response
    {
        $this->initSession($session);
        return $this->render('proj/api.html.twig');
    }

    /**
     * @Route("/proj/api/blackjack/players", name: "api_blackjack_players")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/proj/api/blackjack/players", name: "api_blackjack_players")]
    public function init(SessionInterface $session): Response
    {
        $this->initSession($session);
        $game = $session->get("game");
        $data = [
            'players' => $game->players,
            'currentPlayerIndex' => $game->currentPlayerIndex,
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @Route("/proj/api/blackjack/create", name: "api_blackjack_create", methods: ["POST"])
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/proj/api/blackjack/create", name: "api_blackjack_create", methods: ["POST"])]
    public function create(Request $request, SessionInterface $session): Response
    {
        $numPlayers = (int) $request->request->get('numPlayers', 1);
        $game = new BlackJack($numPlayers);
        $game->dealInitialCards();
        $session->set("game", $game);
        $data = [
            'playerCount' => $game->playerCount,
            'dealerTurn' => $game->dealerTurn,
            'currentPlayerIndex' => $game->currentPlayerIndex,
            'startingMoney' => $game->startingMoney,
            'money' => $game->money
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @Route("/proj/api/blackjack/bet", name: "api_blackjack_bet")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/proj/api/blackjack/hit", name: "api_blackjack_hit")]
    public function hit(SessionInterface $session): Response
    {
        $this->initSession($session);
        $game = $session->get("game");
        $game->hit();
        $session->set("game", $game);
        $data = [
            'players' => $game->players,
            'money' => $game->money,
            'startingMoney' => $game->startingMoney,
            'currentPlayerIndex' => $game->currentPlayerIndex
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @Route("/proj/api/blackjack/stand", name: "api_blackjack_stand")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/proj/api/blackjack/stand", name: "api_blackjack_stand")]
    public function stand(SessionInterface $session): Response
    {
        $this->initSession($session);
        $game = $session->get("game");
        $game->stand();
        $session->set("game", $game);
        $data = [
            'players' => $game->players,
            'currentPlayerIndex' => $game->currentPlayerIndex
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }

    /**
     * @Route("/proj/api/blackjack/nextTurn", name: "api_blackjack_next_turn")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/proj/api/blackjack/nextTurn", name: "api_blackjack_next_turn")]
    public function nextTurn(SessionInterface $session): Response
    {
        $this->initSession($session);
        $game = $session->get("game");
        $game->nextTurn();
        $session->set("game", $game);
        $data = [
            'currentPlayerIndex' => $game->currentPlayerIndex
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        return $response;
    }
}
