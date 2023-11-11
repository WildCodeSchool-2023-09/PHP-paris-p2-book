<?php

namespace App\Model;

class GlobalLibraryManager extends AbstractManager
{
    public const TABLE = 'book';


    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT book.title, book.written_at, author.firstname, author.lastname, book_editor.cover 
        FROM book 
        JOIN author ON book.id=author.id
        JOIN book_editor ON book.id=book_editor.id';
        
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }

}
