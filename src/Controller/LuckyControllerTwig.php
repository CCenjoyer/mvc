<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    /**
     * @Route("/lucky", name="lucky")
     * @return Response
     */
    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);
        $data = [
            'number' => $number
        ];
        return $this->render('lucky_number.html.twig', $data);
    }
}
