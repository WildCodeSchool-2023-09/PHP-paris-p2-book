<?php

namespace App\Model;

use PDO;

class BookAuthorManager extends AbstractManager
{
    public const TABLE = 'book_author';

    public function insert($bookId, $authorId): bool
    {
        $query  = 'INSERT INTO ' . self::TABLE . ' (book_id, author_id) '; 
        $query .= 'VALUES (:book_id, :author_id);';

        $statement = $this->pdo->prepare($query);
        
        $statement->bindValue(":book_id", $bookId, PDO::PARAM_INT);
        $statement->bindValue(":author_id", $authorId, PDO::PARAM_INT);
        
        return $statement->execute();
    }

    public function findOne(int $bookId, int $authorId): array|false
    {
        $query  = 'SELECT * FROM ' . self::TABLE . ' '; 
        $query .= 'WHERE book_id = :book_id ';
        $query .= 'AND author_id = :author_id;';

        $statement = $this->pdo->prepare($query);
        
        $statement->bindValue(":book_id", $bookId, PDO::PARAM_INT);
        $statement->bindValue(":author_id", $authorId, PDO::PARAM_INT);
        
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}