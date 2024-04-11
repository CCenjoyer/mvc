<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardHand;
use App\Cards\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardsController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function showSession(
        SessionInterface $session
    ): Response {
        $data = [
            'session' => $session->all()
        ];
        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session/delete")]
    public function deleteSession(
        SessionInterface $session
    ): Response {
        $session->clear();
        $this->addFlash(
            'success',
            'Session was successfully cleared'
        );
        return $this->redirectToRoute('session');
    }

    #[Route("/card", name: "card")]
    public function card(
        SessionInterface $session
    ): Response {


        $deck = new DeckOfCards();
        $session->set("deck", $deck);
    

        return $this->render('cards/card.html.twig');
    }
}
