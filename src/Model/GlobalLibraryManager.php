<?php

namespace App\Model;

class GlobalLibraryManager extends AbstractManager
{
    public const TABLE = 'book';

    public const AUTHOR = 'author';

    public const BOOK_EDITOR = 'book_editor';

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT ' . static::TABLE . '.title, ' . static::TABLE . '.written_at, '
        . static::AUTHOR . '.firstname, ' . static::AUTHOR . '.lastname, ' . static::BOOK_EDITOR . '.cover 
        FROM ' . static::TABLE . ' 
        JOIN ' . static::AUTHOR . ' ON ' . static::TABLE . '.id = ' . static::AUTHOR . '.id 
        JOIN ' . static::BOOK_EDITOR . ' ON ' . static::TABLE . '.id = ' . static::BOOK_EDITOR . '.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }
}
