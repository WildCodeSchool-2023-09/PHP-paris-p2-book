<?php

namespace App\Model;

use PDO;

class GenreManager extends AbstractManager
{
    public const TABLE = 'genre';

    public const GENRES = ['Action', 'Biography', 'Comedy', 'Essay',
    'Fantasy', 'Historical', 'Horror', 'Journalistic',
    'Philosophical', 'Political', 'Romance', 'Satire',
    'Sci-Fiction', 'Theatre', 'Thriller'];

    public function findOneByLabel(string $label): array|false
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ';
        $query .= 'WHERE label = "' . $label . '";';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
