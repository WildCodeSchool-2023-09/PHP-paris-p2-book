<?php

use App\Model\GenreManager;
use App\Model\TagManager;

require 'vendor/autoload.php';
if (file_exists('config/db.php')) {
    require 'config/db.php';
} else {
    require 'config/db.php.dist';
}

require 'config/config.php';
require 'src/Model/BookManager.php';



try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . '; charset=utf8',
        DB_USER,
        DB_PASSWORD
    );

    $pdo->exec('DROP DATABASE IF EXISTS ' . DB_NAME);
    $pdo->exec('CREATE DATABASE ' . DB_NAME);
    $pdo->exec('USE ' . DB_NAME);

    if (is_file(DB_DUMP_PATH) && is_readable(DB_DUMP_PATH)) {
        $sql = file_get_contents(DB_DUMP_PATH);
        $statement = $pdo->prepare($sql);
        $statement->execute();

        foreach (GenreManager::GENRES as $genre) {
            $query = 'INSERT INTO ' . GenreManager::TABLE . ' (label) VALUES ("' . $genre . '");';
            $statement = $pdo->prepare($query);
            $statement->execute();
        }
        foreach (TagManager::TAGS as $tag) {
            $query = 'INSERT INTO ' . TagManager::TABLE . ' (label) VALUES ("' . $tag . '");';
            $statement = $pdo->prepare($query);
            $statement->execute();
        }
    } else {
        echo DB_DUMP_PATH . ' file does not exist';
    }
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
