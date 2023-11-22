<?php

namespace App\Controller;

use App\Model\BookManager;
use App\Model\ReviewManager;

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
        $reviewManager = new ReviewManager();

        $trending = $bookManager->search([]);
        $reviews = $reviewManager->getThreeLatests(1);
        $foryou = $bookManager->search([]);

        return $this->twig->render(
            'Home/index-user.html.twig',
            ['sectionName' => 'Dashboard', 'trending' => $trending, 'forYou' => $foryou, 'reviews' => $reviews]
        );
    }
}
