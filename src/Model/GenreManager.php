<?php

namespace App\Model;

use PDO;

class GenreManager extends AbstractManager
{
    public const TABLE = 'genre';

    public const GENRES = ['Action', 'Adventure', 'Bibliography', 'Biography', 'Comedy', 'Cookbook', 'Epic', 'Essay',
    'Encyclopedic', 'Fabulation', 'Fantasy', 'Folklore', 'Historical', 'Horror', 'Journalistic', 'Mystery',
    'Paranoid', 'Pastoral', 'Philosophical', 'Political', 'Realist', 'Religious', 'Romance', 'Satire',
    'Science fiction', 'Social', 'Theatre', 'Thriller', 'Travel', 'Western'];

    public function findOneByLabel(string $label): array|false
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ';
        $query .= 'WHERE label = "' . $label . '";';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
