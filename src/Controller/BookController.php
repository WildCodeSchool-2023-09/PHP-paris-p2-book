<?php

namespace App\Controller;

use App\Model\BookManager;

class BookController extends AbstractController
{

    public const HIGHER_LIMIT = 150;
    public const LOWER_LIMIT = 50;
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $book = array_map('trim', $_POST);
            if(empty($book['book_title'])){
                $errors['book_title'][] = "Vous devez indiquer le titre de l'ouvrage";
            }
            elseif(strlen($book['book_title'])>self::HIGHER_LIMIT){
                $errors['book_title'][] = "Le titre de l'ouvrage est trop long. Il doit être inférieur à 150 caractères";
            }
            if(empty($book['book_written_at'])){
                $errors['book_writing_year'][] = "Vous devez indiquer l'année de parution ou de publication de l'ouvrage";
            }
            if(empty($book['genre_label'])){
                $errors['genre_label'][] = "Vous devez indiquer le genre de l'ouvrage";
            }
            elseif(strlen($book['genre_label'])>self::LOWER_LIMIT){
                $errors['genre_label'][] = "Le genre est trop long. Il doit être inférieur à 50 caractères";
            }
            if(empty($book['author_firstname'])){
                $errors['author_firstname'][] = "Vous devez indiquer le prénom de l'auteur";
            }
            elseif(strlen($book['author_firstname'])>self::HIGHER_LIMIT){
                $errors['author_firstname'][] = "Le prénom de l'auteur est trop long. Il doit être inférieur à 150 caractères";
            }
            if(empty($book['author_lastname'])){
                $errors['author_lastname'][] = "Vous devez indiquer le nom de l'auteur";
            }
            elseif(strlen($book['author_lastname'])>self::HIGHER_LIMIT){
                $errors['author_lastname'][] = "Le nom de l'auteur est trop long. Il doit être inférieur à 150 caractères";
            }
            if(empty($book['book_editor_isbn'])){
                $errors['book_editor_isbn'][] = "Vous devez indiquer le numéro ISBN de l'ouvrage";
            }
            if(empty($book['book_editor_synopsis'])){
                $errors['book_editor_synopsis'][] = "Vous devez indiquer le synopsis de l'ouvrage";
            }
            if(empty($book['book_editor_nb_pages'])){
                $errors['book_editor_nb_pages'][] = "Vous devez indiquer le nombre de pages de l'ouvrage";
            }
            if(empty($_FILES['book_editor_cover']['name'][0])){
                $errors['book_editor_cover'][] = "Vous devez indiquer la photo de couverture de l'ouvrage";
            }
            if(!empty($_FILES['book_editor_cover']['name'][0])){
                $cover = $_FILES['book_editor_cover'];
                $authorizedExtensions = ['jpeg', 'jpg' ,'png', 'gif', 'webp',];
                $maxFileSize = 1000000;
                $cover_size = $cover['size'];
                $extension = $cover['type'];
                $extension = explode("/", $extension);
                $extension = end($extension);
                if( (!in_array($extension, $authorizedExtensions))){
                    $errors['book_editor_cover'][] = 'Veuillez sélectionner une image de type Jpg, Jpeg, Gif, Webp ou Png !';
                }
        
                if( file_exists($cover['tmp_name']) && $cover_size > $maxFileSize)
                {
                    $errors['book_editor_cover'][] = "Votre fichier est trop volumineux";
                }
                $uploadDir = 'uploads/';
                $uploadFile = $uploadDir . uniqid() . "." . $extension;
                if (empty($errors)) {
                    move_uploaded_file($cover['tmp_name'], $uploadFile);
                }
            }
            
            if(empty($errors)){
                $bookManager = new BookManager();
                if($bookManager->checkIfBookExists($book) === false || $bookManager->checkIfEditorExists($book) === false){
                    if($bookManager->checkIfAuthorExists($book) === false){
                        $bookManager->insertIntoAuthor($book);
                    }
                    if($bookManager->checkIfGenreExists($book) === false){
                        $bookManager->insertIntoGenre($book);
                    }
                    if($bookManager->checkIfEditorExists($book) === false){
                        $bookManager->insertIntoEditor($book);
                    }
                    if($bookManager->checkIfBookExists($book) === false){
                        $bookManager->insertIntoBook($book);
                    }
                    $id = $bookManager->insertIntoBookEditor($book, $uploadFile);
                    header('Location:/library/show?id=' . $id);
                }
                return null;
            }


        }
        return $this->twig->render('Book/_add-form.html.twig');
    }
}