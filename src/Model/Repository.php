<?php
namespace App\Model;

use Database\DBConnection;
use PDO;

abstract class Repository {

    protected $db;
    protected $table;

    public function __construct(DBConnection $db) {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->read("SELECT * FROM {$this->table}");
    }

    public function findById(int $id): Repository
    {
        return $this->read("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function create(array $data) {
        $first = "";
        $second = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ", ";
            $first .= "{$key}{$comma}";
            $second .= ":{$key}{$comma}";
            $i++ ;

        }

//        var_dump($first, $second); die();
        return $this->write("INSERT INTO {$this->table} ($first) VALUES ($second)", $data);
    }

    public function update(int $id, array $data) {
        $sql = "";
        $i = 1;

        foreach ($data as $key => $val) {
            $comma = $i === count($data) ? " " : ', ';
            $sql .= "{$key} = :{$key}{$comma}";
            $i++;
        }
        $data['id'] = $id;

        return $this->write("UPDATE {$this->table} SET {$sql} WHERE id = :id", $data);
    }

    public function delete(int $id): bool
    {
        return $this->write("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function write(string $sql, array $param = null) {
        $method = is_null($param) ? 'query' : 'prepare';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->execute($param);
    }

    public function read(string $sql, array $param = null, bool $single = null) {
        $method = is_null($param) ? 'query' : 'prepare';
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        $stmt->execute($param);
        return $stmt->$fetch();
    }

    /*public function query(string $sql, array $param = null, bool $single = null) {
        $method = is_null($param) ? 'query' : 'prepare';

        if (
            strpos($sql, 'DELETE') === 0
            || strpos($sql, 'UPDATE') === 0
            || strpos($sql, 'INSERT') === 0) {

            $stmt = $this->db->getPDO()->$method($sql);
            $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
            return $stmt->execute($param);
        }
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        if ($method === 'query') {
            return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }*/

}