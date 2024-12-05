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

    /**
     * @param SessionInterface $session
     * @return void
     */
    private function initRound(SessionInterface $session): void
    {
        $game = $session->get('game');
        if (!$game instanceof BlackJack) {
            $game = new BlackJack();
            $game->dealInitialCards();
            $session->set('game', $game);
        }
    }

    /**
     * @param SessionInterface $session
     * @param Request $request
     * @return Response
     */
    #[Route('/proj/init', name: 'blackjack_init', methods: ['POST'])]
    public function init(
        SessionInterface $session,
        Request $request
    ): Response {
        $money = $request->request->getInt('startingMoney', 100);
        $players = $request->request->getInt('players', 1);
        $this->initSession($session, $money, $players);
        return $this->redirectToRoute('blackjack_game_bets');
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj', name: 'blackjack')]
    public function index(SessionInterface $session): Response
    {
        $this->initSession($session);
        $this->initRound($session);
        return $this->render('proj/index.html.twig');
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/about', name: 'blackjack_about')]
    public function about(SessionInterface $session): Response
    {
        $this->initSession($session);
        return $this->render('proj/about.html.twig');
    }
}
