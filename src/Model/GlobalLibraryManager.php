<?php

namespace App\Model;

class GlobalLibraryManager extends AbstractManager
{
    public const TABLE = 'book';
    public const AUTHOR = 'author';
    public const BOOK_EDITOR = 'book_editor';
    public const GENRE = 'genre';
    public const EDITOR = 'editor';

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT ' . self::TABLE . '.title, ' . self::TABLE . '.written_at, ' . self::AUTHOR . '.firstname, ' . self::AUTHOR . '.lastname, ' . self::GENRE . '.label as glabel, '  
                . self::EDITOR . '.label,' . self::BOOK_EDITOR . '.cover 
                FROM ' . self::TABLE . ' 
                JOIN ' . self::AUTHOR . ' ON ' . self::TABLE . '.id = ' . self::AUTHOR . '.id 
                JOIN ' . self::BOOK_EDITOR . ' ON ' . self::TABLE . '.id = ' . self::BOOK_EDITOR . '.id
                JOIN ' . self::GENRE . ' ON ' . self::TABLE . '.id = ' . self::GENRE . '.id
                JOIN ' . self::EDITOR . ' ON ' . self::TABLE . '.id = ' . self::EDITOR . '.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }
}
