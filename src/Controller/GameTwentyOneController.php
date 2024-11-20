<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cards\GameTwentyOne;

class GameTwentyOneController extends AbstractController
{
    /**
     * @Route("/game/doc", name="game_docs")
     * @return Response
     */
    #[Route("/game/doc", name: "game_docs")]
    public function init(): Response
    {
        return $this->render('twenty_one/game_docs.html.twig');
    }

    /**
     * @Route("/game", name="game_information")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/game", name: "game_information")]
    public function gameInfo(SessionInterface $session): Response
    {
        $this->initSession($session);
        return $this->render('twenty_one/game_info.html.twig');
    }

    /**
     * @Route("/game/reset", name="game_reset")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/game/reset", name: "game_reset")]
    public function reset(SessionInterface $session): Response
    {
        $this->initSession($session);
        return $this->redirectToRoute('game');
    }

    /**
     * @Route("/game/play", name="game")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/game/play", name: "game")]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has('game')) {
            $session->set('game', new GameTwentyOne());
        }

        /** @var GameTwentyOne $game */
        $game = $session->get('game');

        $data = [
            'playerHand' => $game->getPlayerHand(),
            'playerScore' => $game->getPlayerScore(),
            'dealerHand' => $game->getDealerHand(),
            'dealerScore' => $game->getDealerScore(),
            'deckCount' => $game->getDeckCount(),
            'isGameOver' => $game->isGameOver(),
            'winner' => $game->isGameOver() ? $game->determineWinner() : null,
        ];

        return $this->render('/twenty_one/game.html.twig', $data);
    }

    /**
     * @Route("/game/hit", name="twenty_one_hit")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/game/hit", name: "twenty_one_hit")]
    public function draw(SessionInterface $session): Response
    {
        /** @var GameTwentyOne $game */
        $game = $session->get('game');
        $game->drawPlayerCard();
        $session->set('game', $game);

        return $this->redirectToRoute('game');
    }

    /**
     * @Route("/game/stand", name="twenty_one_stand")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/game/stand", name: "twenty_one_stand")]
    public function stand(SessionInterface $session): Response
    {
        /** @var GameTwentyOne $game */
        $game = $session->get('game');
        while ($game->getDealerScore() < 17) {
            $game->drawDealerCard();
        }
        $session->set('game', $game);

        return $this->redirectToRoute('game');
    }

    /**
     * @param SessionInterface $session
     * @return void
     */
    private function initSession(SessionInterface $session): void
    {
        $game = new GameTwentyOne();
        $session->set('game', $game);
    }
}
