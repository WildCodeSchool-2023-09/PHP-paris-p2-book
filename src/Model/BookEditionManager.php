<?php

namespace App\Model;

use PDO;

class BookEditionManager extends AbstractManager
{
    public const TABLE = 'book_edition';

    public function selectOneById(int $id): array|false
    {
        $statement = $this->pdo->prepare('SELECT b.title, b.written_at, be.cover,  be.synopsis, be.nb_pages, r.note, r.difficulty, a.firstname, a.lastname FROM ' . static::TABLE . ' AS be JOIN book AS b JOIN review AS r JOIN author AS a ON b.id=be.book_id WHERE b.id=:id');
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
}
