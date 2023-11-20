<?php

// sélectionner les livres avec les plus de reviews que l'utiliateur ne possède pas
class Algo

{

    public function genreMostReadForOneUser(string $user): array|false
    {   
        $query  = 'SELECT g.label, COUNT(*) AS nb_label FROM ' . GenreManager::TABLE . ' AS g ';
        $query .= 'INNER JOIN ' . BookGenreManager::TABLE . ' AS bg ON g.id = bg.genre_id ';
        $query .= 'INNER JOIN ' . BookManager::TABLE . ' AS b ON bg.book_id = b.id ';
        $query .= 'INNER JOIN ' . BookEditorManager::TABLE . ' AS be ON be.book_id = b.id ';
        $query .= 'INNER JOIN ' . UserBookEditorManager::TABLE . ' AS ube ON be.id = ube.book_editor_id ';
        $query .= 'INNER JOIN ' . UserManager::TABLE . ' AS u ON u.id = ube.user_id ';
        $query .= 'WHERE u.id = ' . $user . ' ';
        $query .= 'GROUP BY g.label ';
        $query .= 'ORDER BY nb_label DESC ';
        $query .= 'LIMIT 3;';

        $statement = $this->pdo->query($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function authorMostReadForOneUser(string $user): array|false
    {
        $query  = 'SELECT a.firstname, a.lastname, COUNT(*) AS nb_per_name FROM ' . AuthorManager::TABLE . ' AS a ';
        $query .= 'INNER JOIN ' . BookAuthorManager::TABLE . ' AS ba ON a.id = ba.author_id ';
        $query .= 'INNER JOIN ' . BookManager::TABLE . ' AS b ON bg.book_id = b.id ';
        $query .= 'INNER JOIN ' . BookEditorManager::TABLE . ' AS be ON be.book_id = b.id ';
        $query .= 'INNER JOIN ' . UserBookEditorManager::TABLE . ' AS ube ON be.id = ube.book_editor_id ';
        $query .= 'INNER JOIN ' . UserManager::TABLE . ' AS u ON u.id = ube.user_id ';
        $query .= 'WHERE u.id = ' . $user . ' ';
        $query .= 'GROUP BY a.name ';
        $query .= 'ORDER BY nb_per_name DESC ';
        $query .= 'LIMIT 5;';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function allBooksFromOneGenreAndUserDontHave(array $genre, string $user): array|false
    {
        $query  = 'SELECT be.* FROM ' . GenreManager::TABLE . ' AS g ';
        $query .= 'INNER JOIN ' . BookGenreManager::TABLE . ' AS bg ON g.id = bg.genre_id ';
        $query .= 'INNER JOIN ' . BookManager::TABLE . ' AS b ON bg.book_id = b.id ';
        $query .= 'INNER JOIN ' . BookEditorManager::TABLE . ' AS be ON be.book_id = b.id ';
        $query .= 'INNER JOIN ' . UserBookEditorManager::TABLE . ' AS ube ON be.id = ube.book_editor_id ';
        $query .= 'INNER JOIN ' . UserManager::TABLE . ' AS u ON u.id = ube.user_id ';
        $query .= 'WHERE u.id != ' . $user . ' AND g.label = ' . $genre . ';';

        $statement = $this->pdo->query($query);

        return $statement->fetchall(PDO::FETCH_ASSOC);
    }

    public function allBooksFromOneAuthorAndUserDontHave(string $firstname, string $lastname, string $user): array|false
    {
        $query  = 'SELECT be.* FROM ' . AuthorManager::TABLE . ' AS a ';
        $query .= 'INNER JOIN ' . BookAuthorManager::TABLE . ' AS ba ON a.id = ba.author_id ';
        $query .= 'INNER JOIN ' . BookManager::TABLE . ' AS b ON bg.book_id = b.id ';
        $query .= 'INNER JOIN ' . BookEditorManager::TABLE . ' AS be ON be.book_id = b.id ';
        $query .= 'INNER JOIN ' . UserBookEditorManager::TABLE . ' AS ube ON be.id = ube.book_editor_id ';
        $query .= 'INNER JOIN ' . UserManager::TABLE . ' AS u ON u.id = ube.user_id ';
        $query .= 'WHERE u.id != ' . $user . ' AND a.firstname = ' . $firstname . ' AND a.lastname = ' . $lastname . ' ;';

        $statement = $this->pdo->query($query);

        return $statement->fetchall(PDO::FETCH_ASSOC);
    }

    $genres = $this->genreMostReadForOneUser($elie);
    foreach($genres as $genre) {
        $books = $this->allBooksFromOneGenreAndUserDontHave($genre, $elie);
    }

    $suggest = array_rand($books, 1);

    $authors = $this->authorMostReadForOneUser($elie);
    foreach($authors as $author) {
        $books = $this->allBooksFromOneAuthorAndUserDontHave($author['firstname'], $author['lastname'], $elie);
    }

    $suggest = array_rand($books, 1);


    public function mostReviewedBooksNotReadByUser(string $user): array|false
    {
        $query  = 'SELECT COUNT(r.book_editor_id) AS nb_per_book_editor FROM ' . ReviewManager::TABLE . ' AS r ';
        $query .= 'INNER JOIN ' . BookEditorManager::TABLE . ' AS be ON be.id = r.book_editor_id ';
        $query .= 'INNER JOIN ' . UserBookEditorManager::TABLE . ' AS ube ON be.id = ube.book_editor_id ';
        $query .= 'INNER JOIN ' . UserManager::TABLE . ' AS u ON u.id = ube.user_id ';
        $query .= 'WHERE u.id != ' . $user . ' ';
        $query .= 'GROUP BY r.book_editor_id ';
        $query .= 'ORDER BY nb_per_book_editor DESC ';
        $query .= 'LIMIT 10;';

        $statement = $this->pdo->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

}


