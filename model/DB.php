<?php
class DB {
  // (A) CONNECT TO DATABASE
  public $error = "";
  private $pdo = null;
  private $stmt = null;
  
  function __construct () {
    $this->pdo = new PDO(
      "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, 
      DB_USER, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  // (B) CLOSE CONNECTION
  function __destruct () {
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  // (C) RUN A SELECT QUERY
  function select ($sql, $data=null) {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
    return $this->stmt->fetchAll();
  }

  // Prepare statement
  public function prepare($sql) {
    return $this->pdo->prepare($sql);
  }

  // Get database connection
  public function getConnection() {
    return $this->pdo;
  }
}

// (D) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "ql_nhayen");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "root");
define("DB_PASSWORD", "");
 
// (E) NEW DATABASE OBJECT
$_DB = new DB();
?>
