<?php

namespace App\Model;

use PDO;

class BookGenreManager extends AbstractManager
{
    public const TABLE = 'book_genre';

    public function insert($bookId, $genreId): bool
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (book_id, genre_id) ';
        $query .= 'VALUES (:book_id, :genre_id);';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(":book_id", $bookId, PDO::PARAM_INT);
        $statement->bindValue(":genre_id", $genreId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function findOne(int $bookId, int $genreId): array|false
    {
        $query  = 'SELECT * FROM ' . self::TABLE . ' ';
        $query .= 'WHERE book_id = :book_id ';
        $query .= 'AND genre_id = :genre_id;';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(":book_id", $bookId, PDO::PARAM_INT);
        $statement->bindValue(":genre_id", $genreId, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
