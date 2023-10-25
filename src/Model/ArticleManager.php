<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'article';

    public const TITLE_MAX_LENGTH = 150;
    public const CONTENT_MIN_LENGTH = 50;

    public function insert(array $article): int
    {
        $query  = "INSERT INTO " . self::TABLE . " (`title`, `content`, `author`, `picture`, `category`)";
        $query .= "VALUES (:title, :content, :author, :picture, :category);";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('title', $article['title']);
        $statement->bindValue('content', $article['content']);
        $statement->bindValue('author', $article['author']);
        $statement->bindValue('picture', $article['picture']);
        $statement->bindValue('category', $article['category']);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
