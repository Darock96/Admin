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
   * @return object
   */
  public function getAll() {
    $SQL = "SELECT * FROM {$this->TABLA}";
    $data  = $this->DB->Consultar($SQL);
    return $data;
  }

  /**
   * Obtinene un registro de una tabla buscando por Primary Key
   *
   * @param int array
   * @return object
   */
  public function getById( $ID ) {
    $SQL = "SELECT * FROM {$this->TABLA} WHERE {$this->PRKEY} = ? LIMIT 1;";
    $data  = $this->DB->ConsultaFila($SQL,[$ID]);
    return $data;
  }


  /**** Métodos manipular datos ****/

  /**
   * Ejecuta una consulta INSERT mysql
   *
   * @param array : array asociativo en forma $array['campo'] = 'valor'
   * @return boolean
   */
  public function insert( $parametros ) {
    $campos = implode(",", array_keys($parametros) );
    $valores = array_values($parametros);
    $params = array_fill(0,count($parametros),'?');
    $param = implode(",", $params );

    $SQL = "INSERT INTO {$this->TABLA} (%s) VALUES (%s)";
    $SQL = sprintf($SQL, $campos, $param);
    $bool = $this->DB->Ejecutar($SQL,$valores);
    return $bool;
  }

  /**
   * Ejecuta una consulta UPDATE mysql
   *
   * @param array $array : array asociativo en forma $array['campo'] = 'valor'
   * @param int $ID : Primary key o ID del registro a actualizar
   * @return boolean
   */
  public function update($parametros,$ID) {
    $campos = array_keys($parametros);
    $valores = array_values($parametros);
    array_push($valores,$ID);

    $set = array_reduce($campos,"self::setParams");
    $set = preg_replace('/(,{1})$/','',$set);

    $SQL = "UPDATE {$this->TABLA} SET %s WHERE $this->PRKEY = ?";
    $SQL = sprintf($SQL, $set);

    $bool = $this->DB->Ejecutar($SQL,$valores);
    return $bool;
  }

  /**
   * Eliminar un registro de una tabla
   *
   * @param int $ID
   * @return boolean
   */
  public function delete($ID) {
    $SQL = "DELETE FROM {$this->TABLA} WHERE {$this->PRKEY} = ?";
    $bool = $this->DB->Ejecutar($SQL,[$ID]);
    return $bool;
  }

  private function setParams($carry,$item) {
    return $carry.$item."=?,";
  }

}

?>
