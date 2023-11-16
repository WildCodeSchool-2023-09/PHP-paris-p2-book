<?php

namespace App\Model;

use PDO;

class BookManager extends AbstractManager
{
    public const TABLE = 'book';

    public function insert(array $data, int $editorId, int $authorId, int $genreId): int
    {
        $book = $this->findOneByTitle($data['book_title']);

        if ($book) {
            $bookId = $book['id'];
        }
        else {
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
