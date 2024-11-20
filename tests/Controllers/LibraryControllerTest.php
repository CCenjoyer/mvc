<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LibraryControllerTest extends WebTestCase
{
    public function testCreateBook(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/create');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create new Book');

        $client->submitForm('Create Book', [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'isbn' => '1234567890',
            'image_url' => 'test.jpg',
        ]);
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.flash-success', 'Book successfully created');
        $this->assertSelectorTextContains('h1', 'Library');
    }

    public function testDeleteLibrary(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/library');
        $link = $crawler->selectLink('Test Book')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Test Book');

        $client->submitForm('Delete');
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.flash-success', 'Book successfully deleted');
        $this->assertSelectorTextContains('h1', 'Library');
    }
}