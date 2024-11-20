<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiQuoteControllerJson
{
    /**
     * @Route("/api/quote", name="quote")
     * @return Response
     */
    #[Route("/api/quote", name: "quote")]
    public function jsonNumber(): Response
    {
        $quotes = [
            '"The only true wisdom is in knowing you know nothing." - Socrates',
            '"In the end, it\'s not the years in your life that count. It\'s the life in your years." - Abraham Lincoln',
            '"The only way to do great work is to love what you do." - Steve Jobs'
        ];

        $dayOfYear = date('z');
        $quoteIndex = $dayOfYear % count($quotes);
        $quote = $quotes[$quoteIndex];

        $timestamp = time();
        $date = date('Y-m-d H:i:s', $timestamp);
        $data = [
            'timestamp' => $timestamp,
            'date' => $date,
            'quote' => $quote
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
        return $response;
    }
}
