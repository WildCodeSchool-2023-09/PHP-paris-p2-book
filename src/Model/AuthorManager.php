<?php

namespace App\Model;

use PDO;

class AuthorManager extends AbstractManager
{

    public const TABLE = 'author';

    public function insert(array $book): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        "(firstname, lastname) VALUES (:firstname, :lastname);");

        $statement->bindValue(':firstname', $book['author_firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $book['author_lastname'], PDO::PARAM_STR);

        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function findOneByName(string $firstname, string $lastname): array|bool
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ';
        $query .= 'WHERE firstname = "' . $firstname . '" ';
        $query .= 'AND lastname = "' . $lastname . '";';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}