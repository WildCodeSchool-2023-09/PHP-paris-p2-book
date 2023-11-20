<?php

namespace App\Controller;

use App\Model\BookEditorManager;
use App\Model\TagManager;
use App\Model\ReviewTagManager;
use App\Model\ReviewManager;

class ReviewController extends AbstractController
{

    public array $errors = [];
    public BookEditorManager $bookEditorManager;

    public TagManager $tagManager;

    public ReviewTagManager $reviewTagManager;

    public ReviewManager $reviewManager;

    public function __construct()
    {
        parent::__construct();

        $this->bookEditorManager = new BookEditorManager();
        $this->tagManager = new TagManager();
        $this->reviewTagManager = new ReviewTagManager();
        $this->reviewManager = new ReviewManager();
    }

    public function add($bookEditorId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);

            $this->checksFormReview($data);

            $userId = rand(1, 5);

            if(empty($this->errors)){
                $reviewId = $this->reviewManager->insert($data, $userId, $bookEditorId);

                $tags = str_split($data['getTag'], " ");
                $labels = [];
                foreach($tags as $tag){
                    $labels[] = $this->tagManager->findOneByLabel($tag);
                }
                foreach($labels as $label){
                    $this->reviewTagManager->insert($reviewId, $label['id']);
                }
            } else {
            return $this->twig->render('review/formReview.html.twig', [
                'errors' => $this->errors,
            ]);
        }
        }
        $book = $this->bookEditorManager->forReview($bookEditorId);

        return $this->twig->render('Review/formReview.html.twig', [
            'book' => $book,
        ]);
    }
    

    public function checksFormReview($data)
    {
        if(empty($data['noteResult'])){
            $this->errors['note'] = "Vous devez indiquer la note de l'ouvrage";
        } elseif ($data['noteResult'] === 0) {
            $this->errors['note'] = "Vous ne pouvez pas mettre une note inférieure à 1 étoile";
        } elseif ($data['noteResult'] > 5) {
            $this->errors['note'] = "Vous ne pouvez pas mettre une note supérieure à 5 étoiles";
        }
        if(empty($data['difficultyResult'])){
            $this->errors['difficulty'] = "Vous devez indiquer la difficulté de l'ouvrage";
        } elseif ($data['difficultyResult'] === 0) {
            $this->errors['difficulty'] = "Vous ne pouvez pas mettre une difficulté inférieure à 1 étoile";
        } elseif ($data['difficultyResult'] > 5) {
            $this->errors['difficulty'] = "Vous ne pouvez pas mettre une difficulté supérieure à 5 étoiles";
        }
        $tags = str_split($data['getTag'], " ");
        foreach($tags as $tag){
            if(!in_array($tag, TagManager::TAGS)){
                $this->errors['tag'] = "Le tag " . $tag . " n'est pas valide";
            }
        }
    }
}