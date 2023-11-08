<?php

namespace App\Controller;

use App\Model\BookEditionManager;

class BookController extends AbstractController
{
    public function show(int $id): string
    {
        $BookEditionManager = new BookEditionManager();
        $book = $BookEditionManager->selectOneById($id);

        return $this->twig->render('Book/show.html.twig', ['book' => $book]);
    }
}
