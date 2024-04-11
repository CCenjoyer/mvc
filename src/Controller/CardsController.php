<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardsController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function initCallback(
        SessionInterface $session
    ): Response {
        $data = [
            'session' => $session->all()
        ];
        return $this->render('session.html.twig', $data);
    }

}
