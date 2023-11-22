<?php

namespace App\Controller;

use App\Model\BookManager;
use App\Model\AuthorManager;
use App\Model\EditorManager;
use App\Model\GenreManager;

class BookController extends AbstractController
{
    public const PARAM_LIST = [
        'name',
        'genre',
        'tag',
        'sort-by',
        'sort-order'
    ];

    public const GENRES = [
        'Philosophy', 'Sci-Fi', 'Politics', 'Novel', 'Horror', 'Drama', 'Detective', 'Fantasy'
    ];

    public const TAGS = [
        'Fun', 'Boring', 'Funny', 'Interesting', 'Original', 'Scary', 'Weird', 'Hopeful', 'Taboulé'
    ];

    public const SORT_BY = ['date', 'reads', 'note'];
    public const SORT_ORDERS = ['ASC', 'DESC'];

    public const HIGHER_LIMIT = 150;
    public const LOWER_LIMIT = 50;

    public const AUTHORIZED_EXTENSIONS = ['jpeg', 'jpg' ,'png', 'gif', 'webp',];
    public const MAX_FILE_SIZE = 1000000;
    public const FORM_ADD_BOOK_READ = "read";
    public const FORM_ADD_BOOK_NOT_YET = "notyet";

    public BookManager $manager;
    public EditorManager $editorManager;
    public GenreManager $genreManager;
    public AuthorManager $authorManager;

    public array $errors = [];

    public function __construct()
    {
        parent::__construct();
        $this->manager = new BookManager();
        $this->editorManager = new EditorManager();
        $this->genreManager = new GenreManager();
        $this->authorManager = new AuthorManager();
    }

    public function cleanSearchInput(&$params, &$paramErrors): bool
    {
        foreach ($_GET as $param => $value) {
            // Clean input
            $param = trim(htmlentities($param));
            // Check if parameter name is correct
            if (in_array($param, self::PARAM_LIST)) {
                // Check if type array (genre & tag)
                if (gettype($value) === 'array') {
                    foreach ($value as $index => $valueOfArray) {
                        $params[$param][$index] = trim(htmlentities($valueOfArray));
                    }
                } else {
                    if (
                        !($param === "sort-by" && !in_array($value, self::SORT_BY))
                        && !($param === "sort-order" && !in_array($value, self::SORT_ORDERS))
                    ) {
                        $params[$param] = trim(htmlentities($value));
                    }
                }
            } else {
                // Add to wrong param list
                $paramErrors[] = '"' . $param . '"';
            }
        }
        return (empty($paramErrors));
    }

    public function showGlobalLibrary(): string
    {
        $params = [];
        $params['name'] = '';
        $paramErrors = [];
        $errors = '';

        // SECURING USER INPUT
        if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET)) {
            if ($this->cleanSearchInput($params, $paramErrors)) {
                $results = $this->manager->search($params);
            } else {
                $errors = 'The following parameters do not exist : ' . implode(', ', $paramErrors) . '.';
                $results = [];
            }
        } else {
            $results = $this->manager->search();
        }

        return $this->twig->render(
            'Book/global-library.html.twig',
            ['errors' => $errors,
            'name' => $params['name'],
            'genres' => self::GENRES,
            'tags' => self::TAGS,
            'books' => $results,
            'sectionName' => 'Library'
            ]
        );
    }

    public function showGlobalLibraryAJAX(): string
    {
        $params = [];
        $params['name'] = '';
        $paramErrors = [];
        // $errors = '';

        // SECURING USER INPUT
        if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_GET)) {
            if ($this->cleanSearchInput($params, $paramErrors)) {
                $results = $this->manager->search($params);
            } else {
                // $errors = 'The following parameters do not exist : ' . implode(', ', $paramErrors) . '.';
                $results = [];
            }
        } else {
            $results = $this->manager->search();
        }

        return json_encode($results);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);

            $this->checksFormAdd($data);
            $this->checksFormAddExtension($data);

            if (empty($this->errors)) {
                $book = $this->manager->findOneByTitleAndEditor($data['book_title'], $data['editor_label']);

                if ($book) {
                    header('Location:/library/show?id=' . $book['id']);
                    exit();
                } else {
                    $editor = $this->editorManager->findOneByLabel($data['editor_label']);
                    $editorId = empty($editor) ? $this->editorManager->insert($data) : $editor['id'];

                    $author = $this->authorManager->findOneByName($data['author_firstname'], $data['author_lastname']);
                    $authorId = empty($author) ? $this->authorManager->insert($data) : $author['id'];

                    $genre = $this->genreManager->findOneByLabel($data['genre_label']);

                    $data['cover'] = $this->manageFormAddCover();

                    $bookId = $this->manager->insert($data, $editorId, $authorId, $genre['id']);

                    if ($data['choice'] === self::FORM_ADD_BOOK_NOT_YET) {
                        header('Location:/library/show?id=' . $bookId);
                        exit();
                    } elseif ($data['choice'] === self::FORM_ADD_BOOK_READ) {
                        header('Location:/review/add?id=' . $bookId);
                        exit();
                    }
                }
            } else {
                return $this->twig->render('Book/formAdd.html.twig', [
                    'errors' => $this->errors,
                ]);
            }
        }

        return $this->twig->render('Book/formAdd.html.twig');
    }

    public function checksFormAdd($book)
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

    public function checksFormAddExtension($book)
    {
        if (empty($book['genre_label'])) {
            $this->errors['genre_label'] = "Vous devez indiquer le genre de l'ouvrage";
        } elseif (strlen($book['genre_label']) > self::LOWER_LIMIT) {
            $this->errors['genre_label'] = "Le genre de l'ouvrage doit être inférieur à 50 caractères";
        }
    }

    public function manageFormAddCover(): string
    {
        if (!empty($_FILES['book_editor_cover']['name'][0])) {
            $cover = $_FILES['book_editor_cover'];

            $coverExtension = explode("/", $cover['type']);
            $coverExtension = end($coverExtension);

            if (!in_array($coverExtension, self::AUTHORIZED_EXTENSIONS)) {
                $this->errors['book_editor_cover'][] =
                'Veuillez sélectionner une image de type Jpg, Jpeg, Gif, Webp ou Png !';
            }

            if (file_exists($cover['tmp_name']) && $cover['size'] > self::MAX_FILE_SIZE) {
                $this->errors['book_editor_cover'][] = "Votre fichier est trop volumineux";
            }

            $uploadFile = UPLOAD_DIR . uniqid() . "." . $coverExtension;

            move_uploaded_file($cover['tmp_name'], $uploadFile);
        } else {
            $uploadFile = "assets/images/cover_question_mark.png";
        }
        return $uploadFile;
    }
}
