<?php

namespace App\Controller;

use App\Model\BookManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(string $login = ''): string
    {
        if (empty($login)) {
            return $this->twig->render('Home/index-guest.html.twig', ['sectionName' => 'MyBookShelf']);
        }

        $bookManager = new BookManager();
        $trending = $bookManager->search([]);
        $foryou = $bookManager->search([]);
        $reviews = $bookManager->search([]);

        return $this->twig->render(
            'Home/index-user.html.twig',
            ['sectionName' => 'Dashboard', 'trending' => $trending, 'forYou' => $foryou, 'reviews' => $reviews]
        );
    }
}
