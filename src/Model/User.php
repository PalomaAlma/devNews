<?php
declare(strict_types = 1);
namespace App\Model;

class User extends Repository {

    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @param string $email
     * @return mixed
     */
    public function getByEmail(string $email)
    {
        return $this->read('SELECT * FROM user WHERE email = ?', [$email], true);
    }

}
