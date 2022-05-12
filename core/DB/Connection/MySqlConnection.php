<?php

namespace App\core\DB\Connection;

class MySqlConnection implements ConnectionInterface
{
  private static $instance = null;
  private $host = "127.0.0.1:3306";
  private $name = "onlineeducation";
  private $user = "root";
  private $pass = "";

  private  $conn;

  private function __construct()
  {
    $this->conn = new \PDO(
      "mysql:host={$this->host};dbname={$this->name}",
      $this->user,
      $this->pass,
      [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
      ]
    );
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  public function getConnection(): \PDO
  {
    return $this->conn;
  }
}