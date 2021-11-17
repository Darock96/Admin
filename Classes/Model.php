<?php

namespace Classes;

/**
 * Contiene los metodos para manipular los datos de una tabla de mysql asi como las consultas mas comunes
 * Se hereda en los modelos del namespace Models
 *
 * @package Classes
 * @author Daniel Oliveros
 */
class Model {
  public $TABLA;
  public $PRKEY = 'id';
  public $DB;

  public function __construct($DB) {
    $this->DB = $DB;
  }

  /**** Métodos obtener ****/

  /**
   * Obtiene todos los registros de una tabla
   *
   * @return array
   */
  public function getAll() {
    $SQL = "SELECT * FROM %s ";
    $SQL = sprintf($SQL,$this->TABLA);
    $data  = $this->DB->Consultar($SQL);
    return $data;
  }

  /**
   * Obtinene un registro de una tabla buscando por Primary Key
   *
   * @param int array
   * @return array
   */
  public function getById( $ID ) {
    $SQL = "SELECT * FROM %s WHERE %s = %d LIMIT 1;";
    $SQL = sprintf($SQL, $this->TABLA, $this->PRKEY, $ID);
    $data  = $this->DB->Consultar($SQL);
    return $data[0];
  }

  /**
   * Obtiene el numero total de registros
   * Se usa en conjunto al Plugin DataTables de jQuery
   *
   * @return int
   */
  public function getTotalRegistros() {
    $SQL = "SELECT COUNT(*) AS total FROM %s ";
    $SQL = sprintf($SQL,$this->TABLA);
    $data  = $this->DB->Consultar($SQL);
    return $data[0]['total'];
  }

  /**
   * Obtiene el numero de registros filtrados
   * Se usa en conjunto al Plugin DataTables de jQuery
   *
   * @param string $JOIN => Fragmento de consulta JOIN SQL con las tablas correspondientes
   * @param string $WHERE => Fragmento de consulta JOIN SQL con los filtros necesarios
   * @return int
   */
  public function getNumFiltrados( $JOIN, $WHERE ) {
    $SQL = "SELECT COUNT(*) AS total FROM %s %s WHERE %s";
    $SQL = sprintf($SQL,$this->TABLA,$JOIN,$WHERE);
    $data  = $this->DB->Consultar($SQL);
    return $data[0]['total'];
  }

  /**
   * Obtiene la pagina de de datos ya filtrados
   * Se usa en conjunto al Plugin DataTables de jQuery
   *
   * @param string $JOIN => Fragmento de consulta SQL haciendo JOIN con las tablas correspondientes
   * @param string $WHERE => Fragmento de consulta SQL con los filtros necesarios
   * @param string $ORDER => Fragmento de consulta SQL indicando la coluna y sentido de ordenamiento
   * @param string $LIMIT => Fragmento de consulta SQL indicando el numero de registros limite
   * @return array
   */
  public function getPaginaFiltrados( $JOIN, $WHERE, $ORDER, $LIMIT ) {
    $SQL = "SELECT * FROM %s %s WHERE %s ORDER BY %s LIMIT %s";
    $SQL = sprintf($SQL,$this->TABLA,$JOIN,$WHERE,$ORDER,$LIMIT);
    $data  = $this->DB->Consultar($SQL);
    return $data;
  }

  /**** Métodos manipular datos ****/

  /**
   * Ejecuta una consulta INSERT mysql
   *
   * @param array : array asociativo en forma $array['campo'] = 'valor'
   * @return boolean
   */
  public function insert( $array ) {
    $campos = ''; $datos = '';
    foreach ($array as $nombre => $valor) {
      $campos .= " $nombre,";
      $datos  .= " '$valor',";
    }
    $campos = preg_replace('/(,{1})$/','',$campos);
    $datos = preg_replace('/(,{1})$/','',$datos);
    $SQL = "INSERT INTO %s (%s) VALUES (%s)";
    $SQL = sprintf($SQL, $this->TABLA, $campos, $datos);
    $bool = $this->DB->Ejecutar($SQL);
    return $bool;
  }

  /**
   * Ejecuta una consulta UPDATE mysql
   *
   * @param array $array : array asociativo en forma $array['campo'] = 'valor'
   * @param int $ID : Primary key o ID del registro a actualizar
   * @return boolean
   */
  public function update($array,$ID) {
    $valores = '';
    foreach ($array as $nombre => $valor) {
      $valores .= " $nombre = '$valor',";
    }
    $valores = preg_replace('/(,{1})$/','',$valores);
    $SQL = "UPDATE %s SET %s WHERE %s = %d";
    $SQL = sprintf($SQL, $this->TABLA, $valores, $this->PRKEY, $ID);
    $bool = $this->DB->Ejecutar($SQL);
    return $bool;
  }

  /**
   * Eliminar un registro de una tabla
   *
   * @param int $ID
   * @return boolean
   */
  public function delete($ID) {
    $SQL = "DELETE FROM %s WHERE %s = %d;";
    $SQL = sprintf($SQL, $this->TABLA, $this->PRKEY, $ID);
    $bool = $this->DB->Ejecutar($SQL);
    return $bool;
  }

}

?>
