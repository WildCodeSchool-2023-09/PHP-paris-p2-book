<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(string $login = ''): string
    {
        if (empty($login)) {
            return $this->twig->render('Home/index-guest.html.twig');
        }
        return $this->twig->render('Home/index-user.html.twig');
    }
}
