<?php
declare(strict_types = 1);
namespace App\Model;

class Post extends Repository {

    protected $table = 'post';
//    private $comments = array();

    public function getComments(): array
    {
        return $this->read('SELECT c.* FROM comment c WHERE post_id = ?', [$this->id]);
    }

}