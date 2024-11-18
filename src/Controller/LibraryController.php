<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository->findAll();

        return $this->render('library/index.html.twig', [
            'library' => $library,
        ]);
    }

    #[Route('/library/create', name: 'library_create', methods: ['GET', 'POST'])]
    public function createBook(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        if ($request->isMethod('POST')) {
            $library = new Library();
            $library->setTitle((string) $request->request->get('title'));
            $library->setAuthor((string) $request->request->get('author'));
            $library->setIsbn((string) $request->request->get('isbn'));
            $library->setImageUrl((string) $request->request->get('image_url'));

            $entityManager = $doctrine->getManager();
            $entityManager->persist($library);
            $entityManager->flush();

            return $this->redirectToRoute('app_library');
        }

        return $this->render('library/create.html.twig');
    }

    #[Route('/library/{bookId}', name: 'library_show', methods: ['GET'])]
    public function showLibrary(
        LibraryRepository $libraryRepository,
        int $bookId
    ): Response {
        $library = $libraryRepository->find($bookId);

        if (!$library) {
            $this->addFlash(
                'warning',
                'Book with id ' . $bookId . ' not found'
            );
            return $this->redirectToRoute('app_library');
        }

        return $this->render('library/book.html.twig', [
            'library' => $library,
        ]);
    }

    #[Route('/library/change/{bookId}', name: 'library_change', methods: ['GET', 'POST'])]
    public function changeLibrary(
        LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
        int $bookId,
        Request $request
    ): Response {
        if ($request->isMethod('POST')) {
            $library = $libraryRepository->find($bookId);
            if (!$library) {
                $this->addFlash(
                    'warning',
                    'Book with id ' . $bookId . ' not found'
                );
                return $this->redirectToRoute('app_library');
            }
            $library->setTitle((string) $request->request->get('title'));
            $library->setAuthor((string) $request->request->get('author'));
            $library->setIsbn((string) $request->request->get('isbn'));
            $library->setImageUrl((string) $request->request->get('image_url'));

            $entityManager = $doctrine->getManager();
            $entityManager->persist($library);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Book with id ' . $bookId . ' changed'
            );
            return $this->redirectToRoute('app_library');
        }

        $library = $libraryRepository->find($bookId);
        if (!$library) {
            throw $this->createNotFoundException(
                'No book found for id '.$bookId
            );
        }
        return $this->render('library/change.html.twig', [
            'library' => $library,
        ]);
    }

    #[Route('/library/delete/{bookId}', name: 'library_delete', methods: ['POST'])]
    public function deleteLibrary(
        LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
        int $bookId
    ): Response {
        $library = $libraryRepository->find($bookId);
        if (!$library) {
            $this->addFlash(
                'warning',
                'Book with id ' . $bookId . ' not found'
            );
            return $this->redirectToRoute('app_library');
        }
        $entityManager = $doctrine->getManager();
        $entityManager->remove($library);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Book with id ' . $bookId . ' deleted'
        );

        return $this->redirectToRoute('app_library');
    }
}
