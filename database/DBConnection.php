<?php

namespace Database;

use PDO;

class DBConnection
{

    private string $dbname;
    private string $host;
    private string $username;
    private string $password;

    public function __construct(string $dbname, string $host, string $username, string $password)
    {
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPDO(): PDO
    {

        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->host}", $this->username, $this->password);
    }
}