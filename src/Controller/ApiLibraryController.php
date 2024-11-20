<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Repository\LibraryRepository;

class ApiLibraryController extends AbstractController
{
    #[Route('/api/library/books', name: 'api_library_books', methods: ['GET'])]
    public function getAllBooks(LibraryRepository $libraryRepository): Response
    {
        $books = $libraryRepository->findAll();
        $data = [];

        foreach ($books as $book) {
            $data[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => $book->getIsbn(),
                'image_url' => $book->getImageUrl(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/library/book-form', name: 'api_library_book_form', methods: ['POST'])]
    public function createBookForm(Request $request): Response
    {
        $isbn = $request->request->get('isbn');

        return $this->redirectToRoute('api_library_book', ['isbn' => $isbn]);
    }

    #[Route('/api/library/book/{isbn}', name: 'api_library_book', methods: ['GET'])]
    public function getBookByIsbn(
        LibraryRepository $libraryRepository,
        string $isbn
    ): Response {
        $book = $libraryRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            return $this->json(['error' => 'Book with ISBN ' . $isbn . ' not found']);
        }

        return $this->json($book);
    }
}
