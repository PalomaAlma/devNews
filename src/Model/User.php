<?php
declare(strict_types = 1);
namespace App\Model;

class User extends Repository {

    protected $table = 'user';

    public function getByEmail(string $email): User
    {
        return $this->read('SELECT * FROM user WHERE email = ?', [$email], true);
    }

}