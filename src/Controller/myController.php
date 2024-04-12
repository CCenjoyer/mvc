<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class myController extends AbstractController
{
    #[Route("/", name: "me")]
    public function me(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/session", name: "session")]
    public function session(): Response
    {
        return $this->render('session.html.twig');
    }

    #[Route("/api", name: "api")]
    public function jsonRoutes(): Response
    {
        // $data = [
        //     'quote' => "/api/quote",
        //     'deck' => "/api/deck",
        //     'shuffle' => "/api/shuffle",
        //     'draw' => "/api/draw",
        //     'drawX' => "/api/draw/:<num>"

        // ];

        return $this->render('api.html.twig');
    }
}
