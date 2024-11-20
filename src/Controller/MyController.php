<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MyController extends AbstractController
{
    /**
     * @Route("/", name="me")
     * @Route("/home", name="home")
     * @return Response
     */
    #[Route("/", name: "me")]
    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('me.html.twig');
    }

    /**
     * @Route("/about", name="about")
     * @return Response
     */
    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/report", name="report")
     * @return Response
     */
    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    /**
     * @Route("/session", name="session")
     * @param SessionInterface $session
     * @return Response
     */
    #[Route("/session", name: "session")]
    public function showSession(
        SessionInterface $session
    ): Response {
        $data = [
            'session' => $session->all()
        ];
        return $this->render('session.html.twig', $data);
    }

    /**
     * @Route("/session/delete", name="session/delete")
     * @param SessionInterface $session
     * @return Response
     */
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

    /**
     * @Route("/api", name="api")
     * @return Response
     */
    #[Route("/api", name: "api")]
    public function jsonRoutes(): Response
    {
        return $this->render('api.html.twig');
    }

    /**
     * @Route("/metrics", name="metrics")
     * @return Response
     */
    #[Route("/metrics", name: "metrics")]
    public function metrics(): Response
    {
        return $this->render('metrics.html.twig');
    }
}
