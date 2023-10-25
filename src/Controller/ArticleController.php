<?php

namespace App\Controller;

use App\Controller\AbstractController;

class ArticleController extends AbstractController
{
    public function add(): string
    {
        return $this->twig->render('Article/add.html.twig');
    }
}
