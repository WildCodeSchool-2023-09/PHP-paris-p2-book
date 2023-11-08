<?php

namespace App\Controller;

use App\Model\GlobalLibraryManager;

class GlobalLibraryController extends AbstractController
{

    public function showAll(): string
    {
        $GlobalLibraryManager = new GlobalLibraryManager();
        $books = $GlobalLibraryManager->selectAll('title');

        return $this->twig->render('GlobalLibrary/global_library.html.twig', ['books' => $books]);
    }

}