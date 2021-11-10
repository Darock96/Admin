<?php

namespace Classes;

class Model {
  public $TABLA;
  public $PRKEY = 'id';
  public $DB;

  public function __construct($DB) {
    $this->DB = $DB;
  }

  /**** Métodos obtener ****/

  public function getAll() {
    $SQL = "SELECT * FROM %s ";
    $SQL = sprintf($SQL,$this->TABLA);
    $data  = $this->DB->Consultar($SQL);
    return $data;
  }

  public function getById( $ID ) {
    $SQL = "SELECT * FROM %s WHERE %s = %d LIMIT 1;";
    $SQL = sprintf($SQL, $this->TABLA, $this->PRKEY, $ID);
    $data  = $this->DB->Consultar($SQL);
    return $data[0];
  }

  public function getTotalRegistros() {
    $SQL = "SELECT COUNT(*) AS total FROM %s ";
    $SQL = sprintf($SQL,$this->TABLA);
    $data  = $this->DB->Consultar($SQL);
    return $data[0]['total'];
  }

  public function getNumFiltrados( $JOIN, $WHERE ) {
    $SQL = "SELECT COUNT(*) AS total FROM %s %s WHERE %s";
    $SQL = sprintf($SQL,$this->TABLA,$JOIN,$WHERE);
    $data  = $this->DB->Consultar($SQL);
    return $data[0]['total'];
  }

  public function getPaginaFiltrados( $JOIN, $WHERE, $ORDER, $LIMIT ) {
    $SQL = "SELECT * FROM %s %s WHERE %s ORDER BY %s LIMIT %s";
    $SQL = sprintf($SQL,$this->TABLA,$JOIN,$WHERE,$ORDER,$LIMIT);
    $data  = $this->DB->Consultar($SQL);
    return $data;
  }

  /**** Métodos manipular datos ****/

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

  public function delete($ID) {
    $SQL = "DELETE FROM %s WHERE %s = %d;";
    $SQL = sprintf($SQL, $this->TABLA, $this->PRKEY, $ID);
    $bool = $this->DB->Ejecutar($SQL);
    return $bool;
  }

}

?>
