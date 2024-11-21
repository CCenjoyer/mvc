<?php

namespace App\Tests\Controller;

use App\Controller\MyController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MyControllerUnitTest extends KernelTestCase
{
    public function testReport(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $session = $this->createMock(SessionInterface::class);
        $session->method('all')->willReturn(['key' => 'value']);
        $container->set(SessionInterface::class, $session);
        $controller = $container->get(MyController::class);
        $response = $controller->report();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Report', (string) $response->getContent());
    }

    public function testHome(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $controller = $container->get(MyController::class);
        $response = $controller->home();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Home', (string) $response->getContent());
    }

    public function testAbout(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $controller = $container->get(MyController::class);
        $response = $controller->about();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('About', (string) $response->getContent());
    }

    public function testMetrics(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $controller = $container->get(MyController::class);
        $response = $controller->metrics();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Metrics', (string) $response->getContent());
    }
}
