<?php

namespace App\Controller;

use App\Model\BookManager;

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

    private $bookManager;

    public function __construct()
    {
        parent::__construct();
        $this->bookManager = new BookManager();
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
                $results = $this->bookManager->search($params);
            } else {
                $errors = 'The following parameters do not exist : ' . implode(', ', $paramErrors) . '.';
                $results = [];
            }
        } else {
            $results = $this->bookManager->search();
        }

        return $this->twig->render(
            'Book/global-library.html.twig',
            ['errors' => $errors,
            'name' => $params['name'],
            'genres' => self::GENRES,
            'tags' => self::TAGS,
            'books' => $results]
        );
    }
}
