<?php

namespace App\Model;

use PDO;

class BookManager extends AbstractManager
{
    public const BOOK_EDITOR_TABLE = 'book_editor';
    public const BOOK_TABLE = 'book';
    public const AUTHOR_TABLE = 'author';
    public const GENRE_TABLE = 'genre';
    public const EDITOR_TABLE = 'editor';


    public function insertIntoBookEditor(array $book, string $uploadFile):int
    {
        $bookId = $this->getBookId($book);
        $editorId = $this->getEditorId($book);
        $statement = $this->pdo->prepare("INSERT INTO " . self::BOOK_EDITOR_TABLE . " (book_id, editor_id, isbn, synopsis, nb_pages, cover, published_at) VALUES (:book_id, :editor_id, :isbn, :synopsis, :nb_pages, :cover, :published_at);");
        $statement->bindValue(':book_id', $bookId, PDO::PARAM_INT);
        $statement->bindValue(':editor_id', $editorId, PDO::PARAM_INT);
        $statement->bindValue(':isbn', $book['book_editor_isbn'], PDO::PARAM_INT);
        $statement->bindValue(':synopsis', $book['book_editor_synopsis'], PDO::PARAM_STR);
        $statement->bindValue(':nb_pages', $book['book_editor_nb_pages'], PDO::PARAM_INT);
        $statement->bindValue(':cover', $uploadFile, PDO::PARAM_STR);
        $statement->bindValue(':published_at', $book['book_editor_published_at'], PDO::PARAM_STR);
        $statement->execute();
        return $this->pdo->lastInsertId();
    }

    public function insertIntoBook(array $book)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::BOOK_TABLE . " (title, written_at) VALUES (:title, :written_at);");
        $statement->bindValue(':title', $book['book_title'], PDO::PARAM_STR);
        $statement->bindValue(':written_at', $book['book_written_at'], PDO::PARAM_INT);
        $statement->execute();
    }

    public function insertIntoAuthor(array $book)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::AUTHOR_TABLE . "(firstname, lastname) VALUES (:firstname, :lastname);");
        $statement->bindValue(':firstname', $book['author_firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $book['author_lastname'], PDO::PARAM_STR);
        $statement->execute();
    }

    public function insertIntoGenre(array $book)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::GENRE_TABLE . " (label) VALUES (:label);");
        $statement->bindValue(':label', $book['genre_label'], PDO::PARAM_STR);
        $statement->execute();
    }

    public function insertIntoEditor(array $book)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::EDITOR_TABLE . " (label) VALUES (:label);");
        $statement->bindValue(':label', $book['editor_label'], PDO::PARAM_STR);
        $statement->execute();
    }

    public function checkIfAuthorExists(array $book): bool
    {
        $statement = $this->pdo->query("SELECT * FROM " . self::AUTHOR_TABLE . ";");
        $infos = $statement->fetchAll(PDO::FETCH_ASSOC);
        $alreadyExists = [];
        foreach( $infos as $info ){
            if(($info['firstname'] === $book['author_firstname']) && ($info['lastname'] === $book['author_lastname'])){
                $alreadyExists[] = "L'auteur existe déjà";
            }
        }
        if(empty($alreadyExists)){
            return false;
        }
        else{
            return true;
        }
    }


    public function checkIfGenreExists(array $book): bool
    {
        $statement = $this->pdo->query("SELECT * FROM " . self::GENRE_TABLE . ";");
        $infos = $statement->fetchAll(PDO::FETCH_ASSOC);
        $alreadyExists = [];
        foreach( $infos as $info ){
            if($info['label'] === $book['genre_label']){
                $alreadyExists[] = "Le genre existe déjà";
            }
        }
        if(empty($alreadyExists)){
            return false;
        }
        else{
            return true;
        }
    }

    public function checkIfBookExists(array $book): bool
    {
        $statement = $this->pdo->query("SELECT * FROM " . self::BOOK_TABLE . ";");
        $infos = $statement->fetchAll(PDO::FETCH_ASSOC);
        $alreadyExists = [];
        foreach( $infos as $info ){
            if($info['title'] === $book['book_title'] && $info['written_at'] === $book['book_written_at']){
                $alreadyExists[] = "Le livre existe déjà";
            }
        }
        if(empty($alreadyExists)){
            return false;
        }
        else{
            return true;
        }
    }

    public function checkIfEditorExists(array $book): bool
    {
        $statement = $this->pdo->query("SELECT * FROM " . self::EDITOR_TABLE . ";");
        $infos = $statement->fetchAll(PDO::FETCH_ASSOC);
        $alreadyExists = [];
        foreach( $infos as $info ){
            if($info['label'] === $book['editor_label']){
                $alreadyExists[] = "L'éditeur existe déjà";
            }
        }
        if(empty($alreadyExists)){
            return false;
        }
        else{
            return true;
        }
    }

    public function getBookId(array $book): array
    {
        $statement = $this->pdo->query("SELECT id FROM " . self::BOOK_TABLE . " WHERE title = " . '"' . $book['book_title'] . '"' . ";");
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getEditorId(array $book): array
    {
        $statement = $this->pdo->query("SELECT id FROM " . self::EDITOR_TABLE . " WHERE label = " . '"' . $book['editor_label'] . '"' . ";");
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

}