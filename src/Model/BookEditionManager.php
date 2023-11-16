<?php

namespace App\Model;

use PDO;

class BookEditionManager extends AbstractManager
{
    public const TABLE = 'book_edition';

    public function selectOneById(int $id): array|false
    {
        $statement = $this->pdo->prepare('SELECT b.title, b.written_at, be.cover, be.langue, be.synopsis, be.isbn, be.nb_pages, r.note, r.reading_time, r.difficulty, a.firstname, a.lastname, e.label, g.label FROM ' . static::TABLE . ' AS be JOIN book b JOIN review r JOIN author a JOIN editor e JOIN genre g ON b.id=be.book_id WHERE b.id=:id');
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }
}
