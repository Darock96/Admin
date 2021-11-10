<?php
namespace Classes;

use PDOException;
use PDO;

define("HOST","mysql:host=".$_ENV['DB_HOST']);
define("DBNAME","dbname=".$_ENV['DB_DATABASE']);
define("USER",$_ENV['DB_USER']);
define("PASS",$_ENV['DB_PASS']);

class DBManager {
  private $conn;

  public function __construct() {
    $this->conn = null;
    try {
      $this->conn = new PDO ( HOST.";".DBNAME, USER, PASS );
      $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) { echo "Connection failed: " . $e->getMessage(); }
  }

  public function Ejecutar($sql) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ){
        echo $sql." --- * ---";
        echo $e->getMessage();
      }
      return false;
    }
  }

  public function Consultar($sql) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ){
        echo $sql." --- * ---";
        echo $e->getMessage();
      }
      return false;
    }
  }

  public function GetLastInsertID() {
    try {
      $id = $this->conn->lastInsertId();
      return $id;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  public function BeginTransaction() {
    try {
      $this->conn->beginTransaction();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  public function Rollback() {
    try {
      $this->conn->rollBack();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  public function Commit() {
    try {
      $this->conn->commit();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  public function Close() {
    try {
      $this->conn = null;
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV'] == "dev" ) echo $e->getMessage();
      return false;
    }
  }

}
?>
