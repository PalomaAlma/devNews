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

    /**
     * @return array
     * find all
     */
    public function all(): array
    {

        return $this->read("SELECT * FROM {$this->table}");
    }

    /**
     * @param int $id
     * @return Repository
     * find an entity by id
     */
    public function findById(int $id): Repository
    {

        return $this->read("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    /**
     * @param int $page
     * @param int $offset
     * @return array
     * find entities by page (for pagination)
     */
    public function findByPage(int $page, int $offset): array
    {
        return $this->read("SELECT * FROM {$this->table} LIMIT 5 OFFSET {$offset}");
    }

    /**
     * @param array $data
     * @return bool
     * create an entity
     */
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

    /**
     * @param int $id
     * @param array $data
     * @return bool
     * update an entity
     */
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

    /**
     * @param int $id
     * @return bool
     * delete an entity
     */
    public function delete(int $id): bool
    {

        return $this->write("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * @param string $sql
     * @param array|null $param
     * @return bool
     * write for create, update & delete
     */
    public function write(string $sql, array $param = null): bool
    {
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        return $stmt->execute($param);
    }

    /**
     * @param string $sql
     * @param array|null $param
     * @param bool|null $single
     * @return mixed
     * read for find functions
     */
    public function read(string $sql, array $param = null, bool $single = null)
    {
        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->setfetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        $stmt->execute($param);

        return $stmt->$fetch();
    }

}
