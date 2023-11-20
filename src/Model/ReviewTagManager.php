<?php

namespace App\Model;

use PDO;

class ReviewTagManager extends AbstractManager
{
    public const TABLE = 'review_tag';

    public function insert($reviewId, $tagId): bool
    {
        $query  = 'INSERT INTO ' . self::TABLE . ' (review_id, tag_id) ';
        $query .= 'VALUES (:review_id, :tag_id);';

        $statement = $this->pdo->prepare($query);

        $statement->bindValue(":review_id", $reviewId, PDO::PARAM_INT);
        $statement->bindValue(":tag_id", $tagId, PDO::PARAM_INT);

        return $statement->execute();
    }
}
