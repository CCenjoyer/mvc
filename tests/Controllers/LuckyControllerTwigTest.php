<?php

namespace App\Tests\Controller;

use App\Controller\LuckyControllerTwig;
use Monolog\Test\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;

class LuckyControllerTwigUnitTest extends KernelTestCase
{
    public function testLucky(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $controller = $container->get(LuckyControllerTwig::class);
        $response = $controller->lucky();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getContent();
        $this->assertIsString($content);
        $this->assertStringContainsString('Magic number', $content);
    }
}