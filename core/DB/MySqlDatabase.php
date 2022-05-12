<?php

namespace App\core\DB;

use App\core\DB\Connection\ConnectionInterface;
use App\core\DB\Connection\MySqlConnection;

class MySqlDatabase implements DatabaseInterface
{
    private  $db;
    private  $table;
    private  $query;
    private  $fields = [];

    public function __construct(ConnectionInterface $connection)
    {
        $this->db = $connection->getConnection();
    }

    public static function do()
    {
        return new self(MySqlConnection::getInstance());
    }

    // Add table name in the first place
    public function table(string $table): DatabaseInterface
    {
        $this->table = $table;
        return $this;
    }

    // Create table then exec
    public function create()
    {
        $this->query = "CREATE TABLE {$this->table}";
        return $this;
    }

    // Drop table then exec
    public function drop()
    {
        $this->query = "DROP TABLE {$this->table}";
        return $this;
    }

    // SELECT array $cols from table then fetch or fetchAll
    public function select(array $cols = ['*']): DatabaseInterface
    {
        $this->query =
            "SELECT " . implode(",", $cols) .
            " FROM " . $this->table;
        return $this;
    }

    // SELECT array $cols from table then fetch or fetchAll
    public function insert(array $fields): DatabaseInterface
    {
        $this->fields = $fields;
        $params = array_map(function($v){
            return ":$v";
        }, array_keys($fields));
        $this->query =
            "INSERT INTO " . $this->table .
            "(" . implode(",", array_keys($fields)) . ") " .
            "VALUES (" . implode(",", $params) . ")";
        return $this;
    }

    public function update(array $fields): DatabaseInterface
    {
        $this->fields = $fields;

        $arr = array_map(
            function ($key){
                return "$key = :$key";
            },
            array_keys($fields),
        );

        $this->query = "UPDATE " . $this->table . " SET " . implode(",", $arr);

        return $this;
    }

    public function where(string $val1, string $val2, string $operation = '='): DatabaseInterface
    {
        $this->where = [
            $val1, $val2, $operation
        ];

        // NOTE: WE CAN ADD OR WHERE 
        // NOTE: WE CAN ADD AND WHERE
        $this->query .= " WHERE $val1 $operation '$val2'";
        return $this;
    }

    private function prepare($query)
    {
        $statement = $this->db->prepare($query);
        foreach ($this->fields as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        return $statement;
    }

    public function fetch()
    {
        $statement = $this->prepare($this->query);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAll()
    {
        $statement = $this->prepare($this->query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function exec(): bool
    {
        echo $this->query;
        $statement = $this->prepare($this->query);
        return $statement->execute();
    }
}