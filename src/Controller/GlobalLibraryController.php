<?php

namespace App\Controller;

use App\Model\GlobalLibraryManager;

class GlobalLibraryController extends AbstractController
{
    public function showAll(): string
    {
        $globalLibraryManager = new GlobalLibraryManager();
        $books = $globalLibraryManager->selectAll('title');

        return $this->twig->render('GlobalLibrary/global_library.html.twig', ['books' => $books]);
    }
}
