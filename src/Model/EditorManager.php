<?php

namespace App\Model;

use PDO;

class EditorManager extends AbstractManager
{
    public const TABLE = 'editor';

    public function insert(array $data)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (label) VALUES (:label);");
        $statement->bindValue(':label', $data['editor_label'], PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function findOneByLabel(string $label): array|bool
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ';
        $query .= 'WHERE label = "' . $label . '";';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
