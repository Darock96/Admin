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
      $this->conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ );
    } catch ( PDOException $e ) { echo "Connection failed: " . $e->getMessage(); }
  }

  /**
   * Ejecutar una consulta SQL
   * Acepta consultas que impliquen modificar los datos o su estructura
   * Requiere de un array con los valores
   *
   * @param string $sql
   * @param array $exec
   * @return boolean
   */
  public function Ejecutar($sql,$exec=[]) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($exec);
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
   * Acepta consultas SELECT y devuelve un objeto con el las filas consultadas
   * Requiere de un array con los valores
   *
   * @param string $sql
   * @param string $exec
   * @return object
   */
  public function Consultar($sql,$exec=[]) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($exec);
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
   * Ejecutar una consulta SQL para una sola fila
   * Acepta consultas SELECT y devuelve un objeto de la fila consultada
   * Requiere de un array con los valores
   *
   * @param string $sql
   * @param string $exec
   * @return object
   */
  public function ConsultaFila($sql,$exec=[]) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($exec);
      $result = $stmt->fetch();
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
