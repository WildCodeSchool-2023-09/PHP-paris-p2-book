<?php

namespace App\Controller;

class GlobalLibraryController extends AbstractController
{
/**
     * Display home page
     */
    public function GlobalLibrary(): string
    {
        return $this->twig->render('GlobalLibrary/global_library.html.twig');
    }
}