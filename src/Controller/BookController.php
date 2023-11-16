<?php

namespace App\Controller;

use App\Model\BookEditionManager;

class BookController extends AbstractController
{
    public function show(int $id): string
    {
        $bookEditionManager = new BookEditionManager();
        $book = $bookEditionManager->selectOneById($id);

        return $this->twig->render('Book/show.html.twig', ['book' => $book]);
    }
}
