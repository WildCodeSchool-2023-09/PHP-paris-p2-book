<?php

namespace App\Controller;

use App\Model\BookManager;

class BookController extends AbstractController
{
    public array $errors = [];
    public const HIGHER_LIMIT = 150;
    public const LOWER_LIMIT = 50;

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book = array_map('trim', $_POST);
            $this->checkIfError($book);
            $this->checkIfErrorGenre($book);
            if (empty($this->errors)) {
                $bookManager = new BookManager();
                if (
                    $bookManager->checkIfBookExists($book) === false
                    || $bookManager->checkIfEditorExists($book) === false
                ) {
                    if ($bookManager->checkIfAuthorExists($book) === false) {
                        $bookManager->insertIntoAuthor($book);
                    }
                    if ($bookManager->checkIfGenreExists($book) === false) {
                        $bookManager->insertIntoGenre($book);
                    }
                    if ($bookManager->checkIfEditorExists($book) === false) {
                        $bookManager->insertIntoEditor($book);
                    }
                    if ($bookManager->checkIfBookExists($book) === false) {
                        $bookManager->insertIntoBook($book);
                    }
                    $id = $bookManager->insertIntoBookEditor($book, $this->manageCover());
                    header('Location:/library/show?id=' . $id);
                }
                return null;
            } else {
                return $this->twig->render('Book/_add-form.html.twig', [
                    'errors' => $this->errors,
                ]);
            }
        }
        return $this->twig->render('Book/_add-form.html.twig');
    }

    public function checkIfError($book)
    {
        if (empty($book['book_title'])) {
            $this->errors['book_title'] = "Vous devez indiquer le titre de l'ouvrage";
        } elseif (strlen($book['book_title']) > self::HIGHER_LIMIT) {
            $this->errors['book_title'] = "Le titre de l'ouvrage doit être inférieur à 150 caractères";
        }

        if (strlen($book['author_firstname']) > self::HIGHER_LIMIT) {
            $this->errors['author_firstname'] = "Le prénom de l'auteur doit être inférieur à 150 caractères";
        }

        if (strlen($book['author_lastname']) > self::HIGHER_LIMIT) {
            $this->errors['author_lastname'] = "Le nom de l'auteur doit être inférieur à 150 caractères";
        }

        if (empty($book['book_editor_isbn'])) {
            $this->errors['book_editor_isbn'] = "Vous devez indiquer le numéro ISBN de l'ouvrage";
        }

        if (empty($book['book_editor_synopsis'])) {
            $this->errors['book_editor_synopsis'] = "Vous devez indiquer le synopsis de l'ouvrage";
        }

        if (empty($book['book_editor_nb_pages'])) {
            $this->errors['book_editor_nb_pages'] = "Vous devez indiquer le nombre de pages de l'ouvrage";
        }

        if (empty($book['book_written_at'])) {
            $this->errors['book_writing_year'] = "Vous devez indiquer l'année d'écriture de l'ouvrage";
        }
    }
    public function checkIfErrorGenre($book)
    {
        if (empty($book['genre_label'])) {
            $this->errors['genre_label'] = "Vous devez indiquer le genre de l'ouvrage";
        } elseif (strlen($book['genre_label']) > self::LOWER_LIMIT) {
            $this->errors['genre_label'] = "Le genre de l'ouvrage doit être inférieur à 50 caractères";
        }
    }

    public function manageCover()
    {
        if (!empty($_FILES['book_editor_cover']['name'][0])) {
            $cover = $_FILES['book_editor_cover'];
            $authorizedExtensions = ['jpeg', 'jpg' ,'png', 'gif', 'webp',];
            $maxFileSize = 1000000;
            $coverExtension = $cover['type'];
            $coverExtension = explode("/", $coverExtension);
            $coverExtension = end($coverExtension);
            if (!in_array($coverExtension, $authorizedExtensions)) {
                $this->errors['book_editor_cover'][] =
                'Veuillez sélectionner une image de type Jpg, Jpeg, Gif, Webp ou Png !';
            }
            if (file_exists($cover['tmp_name']) && $cover['size'] > $maxFileSize) {
                $this->errors['book_editor_cover'][] = "Votre fichier est trop volumineux";
            }
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . uniqid() . "." . $coverExtension;
            move_uploaded_file($cover['tmp_name'], $uploadFile);
            return $uploadFile;
        }
        if (empty($_FILES['book_editor_cover']['name'][0])) {
            return $uploadFile = "assets/images/cover_question_mark.png";
        }
    }

    // SEARCH

    // public function search()
    // {
    //     $filters = [
    //         'name' => '',
    //         'genres' => [],
    //         'tags' => [],
    //         'sort-criteria' => NULL,
    //         'sort-order' => 'DESC'
    //     ];

    //     return $this->twig->render('Book/show.html.twig', ['genres' => $this->genres]);
    // }
}
