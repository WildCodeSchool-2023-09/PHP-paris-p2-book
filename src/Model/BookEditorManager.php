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

    public function forReview(int $bookEditorId): array|false
    {
        $query  = 'SELECT be.cover, b.*, a.* FROM ' . self::TABLE . ' as be ';
        $query .= 'INNER JOIN ' . BookManager::TABLE . ' as b ON be.book_id = b.id ';
        $query .= 'INNER JOIN ' . BookAuthorManager::TABLE . ' as ba ON b.id = ba.book_id ';
        $query .= 'INNER JOIN ' . AuthorManager::TABLE . ' as a ON ba.author_id = a.id ';
        $query .= 'WHERE be.id = :id ;';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id', $bookEditorId, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function selectOneById(int $id): array|false
    {
        $statement = $this->pdo->prepare('SELECT b.title, b.written_at, 
        be.cover, be.synopsis, be.isbn, be.nb_pages, 
        r.created_at, r.note, r.reading_time, r.difficulty, r.opinion, 
        a.firstname, a.lastname, e.label, g.label 
        FROM ' . static::TABLE . ' AS be JOIN book b JOIN review r 
        JOIN author a JOIN editor e JOIN genre g ON b.id=be.book_id WHERE b.id=:id');
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
