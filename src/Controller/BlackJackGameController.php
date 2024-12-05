<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cards\BlackJack;
use Symfony\Component\HttpFoundation\Request;

class BlackJackGameController extends AbstractController
{
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
     * @return Response
     */
    #[Route('/proj/game', name: 'blackjack_game')]
    public function game(SessionInterface $session): Response
    {
        $this->initRound($session);
        $game = $session->get('game');
        $data = [
            'players' => $game->players,
            'dealer' => $game->dealerHand,
            'isGameOver' => $game->isGameOver(),
            'money' => $game->money,
            'startingMoney' => $game->startingMoney,
            'isDealerTurn' => $game->dealerTurn,
            'dealerScore' => $game->dealerScore,
            'currentPlayer' => $game->currentPlayerIndex,
            'playersTurnsOver' => $game->checkPlayersTurnsOver(),
            'cardBack' => '🂠',
        ];
        $session->set('game', $game);
        return $this->render('proj/game.html.twig', $data);
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/game/hit', name: 'blackjack_game_hit')]
    public function hit(SessionInterface $session): Response
    {
        $this->initRound($session);
        $game = $session->get('game');
        $game->hit();
        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/game/stand', name: 'blackjack_game_stand')]
    public function stand(SessionInterface $session): Response
    {
        $this->initRound($session);
        $game = $session->get('game');
        $game->stand();
        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/game/bets', name: 'blackjack_game_bets')]
    public function bet(
        SessionInterface $session,
    ): Response {
        $this->initRound($session);
        $game = $session->get('game');
        $data = [
            'players' => $game->players,
            'money' => $game->money,
            'startingMoney' => $game->startingMoney,
        ];
        $session->set('game', $game);
        return $this->render('proj/bets.html.twig', $data);
    }

    /**
     * @param SessionInterface $session
     * @param Request $request
     * @return Response
     */
    #[Route('/proj/game/bets/place', name: 'blackjack_process_bets', methods: ['POST'])]
    public function placeBets(
        SessionInterface $session,
        Request $request
    ): Response {
        $this->initRound($session);
        $game = $session->get('game');
        $players = $game->playerCount;
        $money = $game->money;
        $betTotal = 0;
        for ($i = 1; $i < $players + 1; $i++) {
            $betTotal += $request->request->getInt("player{$i}Bet");
        }
        if ($betTotal > $money) {
            return $this->redirectToRoute('blackjack_game_bets');
        }
        for ($i = 1; $i < $players + 1; $i++) {
            $bet = $request->request->getInt("player{$i}Bet");
            $money -= $bet;
            $game->placeBet($i - 1, $bet);
        }
        $game->money = $money;
        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/game/dealer/draw', name: 'blackjack_dealer_draw')]
    public function dealerDraw(SessionInterface $session): Response
    {
        $game = $session->get('game');
        $game->dealerDraw();
        $session->set('game', $game);
        return $this->redirectToRoute('blackjack_game');
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/game/round/end', name: 'blackjack_round_end')]
    public function roundEnd(SessionInterface $session): Response
    {
        $this->initRound($session);
        $game = $session->get('game');
        $data = [
            'players' => $game->players,
            'dealer' => $game->dealerHand,
            'isGameOver' => $game->isGameOver(),
            'money' => $game->money,
            'startingMoney' => $game->startingMoney,
            'dealerScore' => $game->dealerScore,
        ];
        return $this->render('proj/round_end.html.twig', $data);
    }

    /**
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/proj/game/round', name: 'blackjack_new_round')]
    public function newRound(SessionInterface $session): Response
    {
        $this->initRound($session);
        $game = $session->get('game');
        $game->nextRound();

        return $this->redirectToRoute('blackjack_game_bets');
    }
}
