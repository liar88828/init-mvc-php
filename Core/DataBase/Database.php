<?php
class Database {
  private static $instance = null;
  private $dbh;
  private $stmt;

  private function __construct() {
    $config = require 'Config/Database.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
    $this->dbh = new PDO($dsn, $config['username'], $config['password']);
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public static function getInstance() {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  // Add these methods to match what Model needs
  public function prepare($sql) {
    return $this->dbh->prepare($sql);
  }

  public function lastInsertId() {
    return $this->dbh->lastInsertId();
  }

  // Keep existing methods for backward compatibility
  public function query($sql) {
    $this->stmt = $this->dbh->prepare($sql);
  }

  public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      $type = match (true) {
        is_int($value) => PDO::PARAM_INT,
        is_bool($value) => PDO::PARAM_BOOL,
        is_null($value) => PDO::PARAM_NULL,
        default => PDO::PARAM_STR,
      };
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute() {
    return $this->stmt->execute();
  }

  public function resultSet() {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function single() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  private function __clone() {}
//  private function __wakeup() {}
}