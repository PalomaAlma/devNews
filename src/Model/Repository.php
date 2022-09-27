<?php
namespace App\Model;

use Database\DBConnection;
use PDO;

abstract class Repository
{

    protected DBConnection $db;
    protected $table;

    public function __construct(DBConnection $db)
    {
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

    public function findByPage(int $page, $offset): array
    {
        return $this->read("SELECT * FROM {$this->table} LIMIT 5 OFFSET {$offset}");
    }

    public function create(array $data): bool
    {
        $first = "";
        $second = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ", ";
            $first .= "{$key}{$comma}";
            $second .= ":{$key}{$comma}";
            $i++ ;

        }

        return $this->write("INSERT INTO {$this->table} ($first) VALUES ($second)", $data);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "";
        $i = 1;

        foreach ($data as $key => $val)
        {
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

    public function write(string $sql, array $param = null): bool
    {
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        return $stmt->execute($param);
    }

    public function read(string $sql, array $param = null, bool $single = null)
    {
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        $stmt->execute($param);

        return $stmt->$fetch();
    }

}
