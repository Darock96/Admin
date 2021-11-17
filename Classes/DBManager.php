<?php
namespace Classes;

use PDOException;
use PDO;

/**
 * Conexion a MYSQL
 * Crea una conexion a MYSQL y pone a disposicion sus principales metodos. 
 *
 * @package Classes
 * @author Daniel Oliveros
 */
class DBManager {
  private $conn;

  public function __construct() {
    $this->conn = null;
    $CONNECTION = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}";
    $USER = $_ENV['DB_USER'];
    $PASS = $_ENV['DB_PASS'];
    try {
      $this->conn = new PDO ( $CONNECTION, $USER, $PASS );
      $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) { echo "Connection failed: " . $e->getMessage(); }
  }

  /**
   * Ejecutar una consulta SQL
   * Acepta consultas que impliquen modificar los datos o su estructura
   *
   * @param string $sql
   * @return boolean
   */
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

  /**
   * Ejecutar una consulta SQL
   * Acepta consultas SELECT y devuelve un array asociativo con el resultado de la consulta
   *
   * @param string $sql
   * @return array
   */
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

  /**
   * Obtiene el ID del ultimo elemento insertado
   *
   * @return int
   */
  public function GetLastInsertID() {
    try {
      $id = $this->conn->lastInsertId();
      return $id;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  /**
   * Inicia una transaccion en mysql
   *
   * @return void
   */
  public function BeginTransaction() {
    try {
      $this->conn->beginTransaction();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  /**
   * Ejecuta rollBack mysql
   *
   * @return void
   */
  public function Rollback() {
    try {
      $this->conn->rollBack();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  /**
   * Termina la transaccion exitosamente.
   *
   * @return void
   */
  public function Commit() {
    try {
      $this->conn->commit();
      return true;
    } catch ( PDOException $e ) {
      if( $_ENV['APP_ENV']  == "dev" ) echo $e->getMessage();
      return false;
    }
  }

  /**
   * Destruye la conexion a MYSQL
   *
   * @return void
   */
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
