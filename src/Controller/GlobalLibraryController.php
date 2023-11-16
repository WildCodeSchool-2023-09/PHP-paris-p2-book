<?php

namespace App\Controller;

use App\Model\GlobalLibraryManager;

class GlobalLibraryController extends AbstractController
{
    public function index(): string
    {
        $globalLibraryManager = new GlobalLibraryManager();
        $books = $globalLibraryManager->selectAll('title');
        return $this->twig->render('Book/global-library.html.twig', ['books' => $books]);
    }
}
