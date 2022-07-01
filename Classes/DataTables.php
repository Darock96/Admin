<?php

namespace Classes;

/**
 * DataTables
 * Procesa una peticion GET para el plugin DataTables de JS
 * 
 * @package Classes
 * @author Daniel Oliveros
 */
class DataTables extends DBManager {

  private $TABLA = "";
  private $JOIN = "";
  private $WHERE = "";
  private $CAMPOS = "";
  private $COLS = [];
  private $REQ = [];

  public function __construct() {
    parent::__construct();
  }

  public function getTabla() {
    //Inicializar variables obtenidas en la peticion GET
    $DRAW = $this->REQ['draw'];
    $START = $this->REQ['start'];
    $ROWS = $this->REQ['length'];
    $ICOL = $this->REQ['order'][0]['column'];
    $SORT = $this->REQ['columns'][$ICOL]['name'];
    $DIR = $this->REQ['order'][0]['dir'];
    $SEARCH = $this->REQ['search']['value'];

    //Revisamos si hay algún valor en el campo de búsqueda
    if ( $SEARCH != null && $SEARCH != "" ) {
      $COLS = $this->REQ['columns'];
      $where = "";
      foreach ($COLS as $col) {
        if ($col['searchable'] == 'true') $where .= " {$this->COLS[$col['name']]} LIKE '{$SEARCH}%' OR";
      }
      $where = preg_replace('/(OR{1})$/','',$where);
      $this->WHERE .= "( {$where} )";
    } else {
      $this->WHERE .= " 1 ";
    }

    //Si la tabla se une a otra realizar el JOIN aqui
    $ORDER = " {$SORT} {$DIR} ";
    $LIMIT = " {$START},{$ROWS}";

    //Total de registros en tabla
    $TR = $this->getTotalRegistros();

    //Total de registros filtrados
    $TRF = $this->getNumFiltrados();

    //Pagina de resultados filtrados
    $RESULTADOS = $this->getPaginaFiltrados($ORDER,$LIMIT);

    $_return = array(
      "draw" => $DRAW,
      "iTotalRecords" => $TR,
      "iTotalDisplayRecords" => $TRF,
      "aaData" => $RESULTADOS
    );

    return $_return;
  }

  public function setTabla ( $tabla ) {
    $this->TABLA = $tabla;
  }

  public function setJoin ( $join ) {
    $this->JOIN = $join;
  }

  public function setWhere ( $where ) {
    $this->WHERE = "( {$where} ) AND ";
  }

  public function setRequest ( $request ) {
    $this->REQ = $request;
  }

  public function setColumnas ( $columnas ) {
    $this->COLS = $columnas;
    foreach ($columnas as $as => $col) $this->CAMPOS .= "{$col} AS {$as},";
    $this->CAMPOS = preg_replace('/(,{1})$/','',$this->CAMPOS);
  }

  /**
   * Obtiene el numero total de registros
   *
   * @return int
   */
  private function getTotalRegistros() {
    $SQL = "SELECT COUNT(*) AS total FROM {$this->TABLA}";
    $data  = $this->ConsultaFila($SQL);
    return $data->total;
  }

  /**
   * Obtiene el numero de registros filtrados
   *
   * @return int
   */
  private function getNumFiltrados() {
    $SQL = "SELECT COUNT(*) AS total FROM {$this->TABLA} {$this->JOIN} WHERE {$this->WHERE}";
    $data = $this->ConsultaFila($SQL);
    return $data->total;
  }

  /**
   * Obtiene la pagina de de datos ya filtrados
   *
   * @param string $ORDER => Fragmento de consulta SQL indicando la coluna y sentido de ordenamiento
   * @param string $LIMIT => Fragmento de consulta SQL indicando el numero de registros limite
   * @return array
   */
  private function getPaginaFiltrados( $ORDER, $LIMIT ) {
    $SQL = "SELECT {$this->CAMPOS} FROM {$this->TABLA} {$this->JOIN} WHERE {$this->WHERE} ORDER BY {$ORDER} LIMIT {$LIMIT}";
    $data = $this->Consultar($SQL);
    return $data;
  }

}


?>