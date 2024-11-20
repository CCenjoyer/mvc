<?php

namespace App\Tests\Entity;

use App\Entity\Library;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
    public function testGetSetId(): void
    {
        $library = new Library();
        $this->assertNull($library->getId());
    }

    public function testGetSetTitle(): void
    {
        $library = new Library();
        $title = 'Test Title';
        $library->setTitle($title);
        $this->assertEquals($title, $library->getTitle());
    }

    public function testGetSetIsbn(): void
    {
        $library = new Library();
        $isbn = '1234567890';
        $library->setIsbn($isbn);
        $this->assertEquals($isbn, $library->getIsbn());
    }

    public function testGetSetAuthor(): void
    {
        $library = new Library();
        $author = 'Test Author';
        $library->setAuthor($author);
        $this->assertEquals($author, $library->getAuthor());
    }

    public function testGetSetImageUrl(): void
    {
        $library = new Library();
        $imageUrl = 'test.jpg';
        $library->setImageUrl($imageUrl);
        $this->assertEquals($imageUrl, $library->getImageUrl());
    }
}
