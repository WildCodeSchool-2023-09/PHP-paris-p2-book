<?php

namespace App\Model;

use PDO;

class BookManager extends AbstractManager
{
    public const TABLE = 'book';

    public function filterBy(array $params, int $id = 0): string
    {
        $queries = [];
        $query = "WHERE ";
        foreach ($params as $param => $value) {
            // NAME : book title || author || editor
            if ($param === 'name') {
                $queries[] = ' (b.title LIKE CONCAT("%", :name, "%")
                            OR CONCAT(a.firstname, " ", a.lastname) LIKE CONCAT("%", :name, "%")
                            OR e.label LIKE CONCAT("%", :name, "%"))
                            ';
            }
            // GENRE
            if ($param === 'genre') {
                $genreQueries = [];
                $arrayLength = count($value);
                for ($i = 0; $i < $arrayLength; $i++) {
                    $genreQueries[] = " (g.label = :genre$i)";
                    $queries[] = implode(" OR ", $genreQueries);
                }
            }
            // TAG
            if ($param === 'tag') {
                $tagQueries = [];
                $arrayLength = count($value);
                for ($i = 0; $i < $arrayLength; $i++) {
                    $tagQueries[] = " (t.label = :tag$i)";
                    $queries[] = implode(" OR ", $tagQueries);
                }
            }
        }

        // FILTER BY USER
        if ($id > 0) {
            $queries[] = " user.id = $id";
        }

        $query .= implode(" AND ", $queries);
        return $query;
    }

    public function search(array $params, int $id = 0): array
    {
        $query = file_get_contents("../src/Model/sql/getBooks.sql");

        if (!empty($params)) {
            // FILTER PARAMS
            $query .= $this->filterBy($params, $id);

            // ORDER PARAMS
            $query .= " ORDER BY ";
            if (isset($params['sort-by']) && $params['sort-by'] === 'date') {
                $query .= "date " . $params['sort-order'] . ", ";
            }
            $query .= "be.id DESC;";

            $statement = $this->pdo->prepare($query);

            // BIND VALUES
            foreach ($params as $param => $value) {
                if (!empty($param)) {
                    // ARRAYS
                    if (gettype($value) === 'array') {
                        foreach ($value as $index => $valueOfArray) {
                            $statement->bindValue(":" . $param . $index, $valueOfArray, PDO::PARAM_STR);
                        }
                    } else {
                        // STRINGS
                        $statement->bindValue(":" . $param, $value, PDO::PARAM_STR);
                    }
                }
            }

            $statement->execute();
        } else {
            // ELSE IF NOT PARAMS
            if ($id > 0) {
                $query .= " WHERE user.id = $id";
            }
            $query .= ' ORDER BY be.id DESC;';

            $statement = $this->pdo->query($query);
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(array $data, int $editorId, int $authorId, int $genreId): int
    {
        $book = $this->findOneByTitle($data['book_title']);

        if ($book) {
            $bookId = $book['id'];
        } else {
            $query  = 'INSERT INTO ' . self::TABLE . ' (title, written_at) ';
            $query .= 'VALUES (:title, :written_at);';

            $statement = $this->pdo->prepare($query);

            $statement->bindValue(':title', $data['book_title'], PDO::PARAM_STR);
            $statement->bindValue(':written_at', $data['book_written_at'], PDO::PARAM_INT);

            $statement->execute();

            $bookId = (int) $this->pdo->lastInsertId();
        }

        $bookEditorManager = new BookEditorManager();
        $bookEditorManager->insert($data, $data['cover'], $bookId, $editorId);

        $bookGenreManager = new BookGenreManager();

        if (!$bookGenreManager->findOne($bookId, $genreId)) {
            $bookGenreManager->insert($bookId, $genreId);
        }

        $bookAuthorManager = new BookAuthorManager();

        if (!$bookAuthorManager->findOne($bookId, $authorId)) {
            $bookAuthorManager->insert($bookId, $authorId);
        }

        return $bookId;
    }

    public function findOneByTitleAndEditor(string $title, string $editor): array|false
    {
        $query  = 'SELECT * FROM ' . self::TABLE . ' AS b ';
        $query .= 'INNER JOIN ' . BookEditorManager::TABLE . ' AS be ON be.book_id = b.id ';
        $query .= 'INNER JOIN ' . EditorManager::TABLE . ' AS e ON e.id = be.editor_id ';
        $query .= 'WHERE e.label = :editor_label ';
        $query .= 'AND b.title = :book_title';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':editor_label', $editor);
        $statement->bindValue(':book_title', $title);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findOneByTitle(string $title): array|false
    {
        $query  = 'SELECT * FROM ' . self::TABLE . ' AS b ';
        $query .= 'WHERE b.title = :book_title';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':book_title', $title);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
