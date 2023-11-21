<?php

namespace App\Model;

use PDO;

class TagManager extends AbstractManager
{
    public const TABLE = 'tag';

    public const TAGS = ['Amazing', 'Cry', 'Dark', 'Disappointment', 'Emotion', 'Intense',
    'Joy', 'Laugh', 'Mystery', 'Plot-twist', 'Sad', 'Unexpected', 'Weird', 'Wonder'];

    public function findOneByLabel(string $label): array|false
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ';
        $query .= 'WHERE label = "' . $label . '";';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
