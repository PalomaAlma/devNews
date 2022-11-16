<?php
declare(strict_types = 1);
namespace App\Model;

class Post extends Repository {

    /**
     * @var string
     */
    protected $table = 'post';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->read('SELECT p.id FROM post WHERE id = ?', [$this->id]);
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->read('SELECT c.* FROM comment c WHERE post_id = ?', [$this->id]);
    }

}
