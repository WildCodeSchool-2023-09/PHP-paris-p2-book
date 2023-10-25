<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\ArticleManager;

class ArticleController extends AbstractController
{
    public function add(): string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = array_map('trim', array_map('htmlentities', $_POST));

            if (!isset($article['title']) || empty($article['title'])) {
                $errors['title'] = 'Titre vide';
            }
            if (strlen($article['title']) > ArticleManager::TITLE_MAX_LENGTH) {
                $errors['title'] = 'Titre trop long';
            }
            if (!isset($article['content']) || empty($article['content'])) {
                $errors['content'] = 'Contenu vide';
            }
            if (strlen($article['content']) < ArticleManager::CONTENT_MIN_LENGTH) {
                $errors['content'] = 'Contenu pas assez long';
            }

            if (empty($errors)) {
                $articleManager = new ArticleManager();
                $article['author'] = 'Mickaël';

                if ($articleManager->insert($article) > 0) {
                    // TODO Redirect to article view
                    // header('Location:')
                }
            }
        }

        return $this->twig->render('Article/add.html.twig', ['errors' => $errors]);
    }
}
