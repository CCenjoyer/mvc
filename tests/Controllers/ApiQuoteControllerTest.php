<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiQuoteControllerJsonTest extends WebTestCase
{

    public function testJsonNumber(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/quote', [], [], [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $responseContent = $client->getResponse()->getContent();
        $data = json_decode($responseContent ?: '', true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('quote', $data);

        $this->assertIsInt($data['timestamp']);
        $this->assertIsString($data['date']);
        $this->assertIsString($data['quote']);
    }
}
