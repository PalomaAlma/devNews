<?php
declare(strict_types = 1);
namespace App\Model;

class Comment extends Repository {

    protected $table = 'comment';

    public function getPost()
    {
        return $this->read('SELECT p.* FROM post p WHERE p.id = ?', [$this->id]);
    }
}