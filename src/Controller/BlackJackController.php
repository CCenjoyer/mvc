<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cards\BlackJack;
use Symfony\Component\HttpFoundation\Request;

class BlackJackController extends AbstractController
{
    /**
     * @param SessionInterface $session
     * @return void
     */
    private function initSession(
        SessionInterface $session,
        int $money = 100,
        int $players = 1
    ): void {
        $game = new BlackJack($players, $money);
        $game->dealInitialCards();
        $session->set('game', $game);
    }

    private function initRound(SessionInterface $session): void
    {
        $game = $session->get('game');
        $game->dealInitialCards();
        $session->set('game', $game);
    }

    #[Route('/proj/init', name: 'blackjack_init')]
    public function init(
        SessionInterface $session,
        Request $request
    ): Response {
        $money = $request->query->getInt('startingMoney', 100);
        $players = $request->query->getInt('players', 1);

        $this->initSession($session, $money, $players);
        return $this->redirectToRoute('blackjack_game_bets');
    }

    #[Route('/proj', name: 'blackjack')]
    public function index(SessionInterface $session): Response
    {
        $this->initSession($session);
        $this->initRound($session);
        return $this->render('proj/index.html.twig');
    }

    #[Route('/proj/about', name: 'blackjack_about')]
    public function about(SessionInterface $session): Response
    {
        $this->initSession($session);
        return $this->render('proj/about.html.twig');
    }

    #[Route('/proj/game', name: 'blackjack_game')]
    public function game(SessionInterface $session): Response
    {
        $game = $session->get('game');
        $data = [
            'players' => $game->getPlayers(),
            'dealer' => $game->getDealer(),
            'isGameOver' => $game->isGameOver(),
            'money' => $game->getMoney(),
            'startingMoney' => $game->getMoney(),
            'dealerScore' => $game->dealerScore,
            'currentPlayer' => $game->getCurrentPlayerIndex(),
            'playersTurnsOver' => $game->checkPlayersTurnsOver(),
        ];

        $session->set('game', $game);
        return $this->render('proj/game.html.twig', $data);
    }

    #[Route('/proj/game/hit', name: 'blackjack_game_hit')]
    public function hit(SessionInterface $session): Response
    {
        $game = $session->get('game');
        $game->hit();
        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }

    #[Route('/proj/game/stand', name: 'blackjack_game_stand')]
    public function stand(SessionInterface $session): Response
    {
        $game = $session->get('game');
        $game->stand();
        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }

    #[Route('/proj/game/bets', name: 'blackjack_game_bets')]
    public function bet(
        SessionInterface $session,
        Request $request
    ): Response {
        $game = $session->get('game');
        $data = [
            'players' => $game->getPlayers(),
            'money' => $game->getMoney(),
        ];
        $session->set('game', $game);

        return $this->render('proj/bets.html.twig', $data);
    }

    #[Route('/proj/game/bets/place', name: 'blackjack_process_bets')]
    public function placeBets(
        SessionInterface $session,
        Request $request
    ): Response {
        $game = $session->get('game');
        $players = $game->getPlayerCount();

        for ($i = 0; $i < $players; $i++) {
            $bet = $request->request->getInt("player$i");
            $game->placeBet($i, $bet);
        }

        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }
}
