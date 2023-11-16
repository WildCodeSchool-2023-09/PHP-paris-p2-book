<?php

namespace App\Model;

use PDO;

class BookManager extends AbstractManager
{
    public function filterBy($params): string
    {
        $queries = [];
        $query = "WHERE ";
        foreach ($params as $param => $value) {
            // NAME : book title || author || editor
            if ($param === 'name') {
                $queries[] = ' (b.title LIKE CONCAT("%", :name, "%")
                            OR CONCAT(a.firstname, " ", a.lastname) LIKE CONCAT("%", :name, "%")
                            OR e.label LIKE CONCAT("%", :name, "%"))
                            ';
            }
            // GENRE
            if ($param === 'genre') {
                $genreQueries = [];
                $arrayLength = count($value);
                for ($i = 0; $i < $arrayLength; $i++) {
                    $genreQueries[] = " (g.label = :genre$i)";
                    $queries[] = implode(" OR ", $genreQueries);
                }
            }
            // TAG
            if ($param === 'tag') {
                $tagQueries = [];
                $arrayLength = count($value);
                for ($i = 0; $i < $arrayLength; $i++) {
                    $tagQueries[] = " (t.label = :tag$i)";
                    $queries[] = implode(" OR ", $tagQueries);
                }
            }
        }
        $query .= implode(" AND ", $queries);
        return $query;
    }

    public function search(array $params = []): array
    {
        $query = file_get_contents("../src/Model/sql/search.sql");

        if (!empty($params)) {
            // FILTER PARAMS
            $query .= $this->filterBy($params);

            // ORDER PARAMS
            $query .= " ORDER BY ";
            if (isset($params['sort-by']) && $params['sort-by'] === 'date') {
                $query .= "date " . $params['sort-order'] . ", ";
            }
            $query .= "be.id DESC;";

            $statement = $this->pdo->prepare($query);

            // BIND VALUES
            foreach ($params as $param => $value) {
                if (!empty($param)) {
                    // ARRAYS
                    if (gettype($value) === 'array') {
                        foreach ($value as $index => $valueOfArray) {
                            $statement->bindValue(":" . $param . $index, $valueOfArray, PDO::PARAM_STR);
                        }
                    } else {
                        // STRINGS
                        $statement->bindValue(":" . $param, $value, PDO::PARAM_STR);
                    }
                }
            }

            $statement->execute();
        } else {
            // ELSE IF NOT PARAMS
            $query .= ' ORDER BY be.id DESC;';

            $statement = $this->pdo->query($query);
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
