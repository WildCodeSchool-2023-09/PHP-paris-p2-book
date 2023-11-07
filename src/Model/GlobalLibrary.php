<?php

class GlobalLibrary {

private $connexion;

public function __construct() 

    {
        $this->connexion = new \PDO("mysql:localhost=" . APP_DB_HOST . ";dbname" . APP_DB_NAME . ";charset=utf8" . APP_DB_USER . APP_DB_PASSWORD);
    }

    public function showLibrary() : array
   
        {
            $statement = $this->connexion->query("SELECT * FROM");
            $showLibrary = $statement->fetch(\PDO::FETCH_ASSOC);

            return $showLibrary;
        }
}



    