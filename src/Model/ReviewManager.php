<?php

namespace App\Model;

use PDO;

class ReviewManager extends AbstractManager
{
    public const TABLE = 'review';

    public function insert(array $data, int $userId, int $bookEditorId): int
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (user_id, book_editor_id, note, difficulty, opinion, reading_time) ';
        $query .= 'VALUES (:user_id, :book_editor_id, :note, :difficulty, :opinion, :reading_time);';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':book_editor_id', $bookEditorId, PDO::PARAM_INT);
        $statement->bindValue(':note', $data['noteResult'], PDO::PARAM_INT);
        $statement->bindValue(':difficulty', $data['difficultyResult'], PDO::PARAM_INT);
        $statement->bindValue(':opinion', $data['review_opinion']);
        $statement->bindValue(':reading_time', $data['review_reading_time']);

        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function getThreeLatests(int $id = 0): array
    {
        $query = file_get_contents("../src/Model/sql/getBooks.sql");

        if ($id > 0) {
            $query .= " WHERE user.id != $id";
        }

        $query .= ' ORDER BY r.id DESC LIMIT 3';

        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
