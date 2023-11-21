<?php

namespace App\Model;

use PDO;

class BookEditorManager extends AbstractManager
{
    public const TABLE = 'book_editor';

    public function insert(array $data, string $uploadFile, int $bookId, int $editorId): int
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (book_id, editor_id, isbn, synopsis, nb_pages, cover, published_at) ';
        $query .= 'VALUES (:book_id, :editor_id, :isbn, :synopsis, :nb_pages, :cover, :published_at);';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $statement->bindValue(':editor_id', $editorId, PDO::PARAM_INT);
        $statement->bindValue(':isbn', $data['book_editor_isbn'], PDO::PARAM_INT);
        $statement->bindValue(':synopsis', $data['book_editor_synopsis'], PDO::PARAM_STR);
        $statement->bindValue(':nb_pages', $data['book_editor_nb_pages'], PDO::PARAM_INT);
        $statement->bindValue(':cover', $uploadFile, PDO::PARAM_STR);
        $statement->bindValue(':published_at', $data['book_editor_published_at'], PDO::PARAM_STR);

        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }
}
