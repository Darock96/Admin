<?php

namespace Classes;

/**
 * Response
 *
 * Clase con metodos estaticos que devuelven distintos tipos de respuesta a las peticiones http
 *
 * @package Classes
 * @author Daniel Oliveros
 */
class Response {

  /**
   * Devuelve una vista html, si no se encuentra la vista en el sistema devuelve error 404
   *
   * @param string $view : Ruta de la vista dentro de la carpeta /views/
   * @param array $vars : Los datos que seran pintados en la vista en forma de array asociativo
   * @return vista HTML
   */
  public static function view( $view, $vars = array() ) {
    header('Content-Type: text/html');
    $RUTA = "./views/";
    $template = $RUTA . $view . ".php";

    if ( !file_exists($template) ) {
      include ("./views/templates/view404.html");
      die;
    }

    if ( is_array($vars) ) {
      foreach ( $vars as $k => $v ) {
        $$k = $v;
      }
    }

    include ($template);
    die;
  }

  /**
   * Devuelve una respuesta http tipo JSON
   *
   * @param array $data
   * @return application/json
   */
  public static function json($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    die;
  }

  /**
   * Devuelve un json por http con mensaje de peticion concluida con exito
   *
   * @param string $msg : El mensaje de exito
   * @param string $final : Instrucciones en JS a evaluar en el cliente
   * @return application/json {success, title, message, type, evaluar}
   */
  public static function jExito($msg,$final) {
    header('Content-Type: application/json');
    $json = ["success"=>true,"title"=>"Éxito!","message"=>$msg,"type"=>"success","evaluar"=>$final];
    echo json_encode($json);
    die;
  }

  /**
   * Devuelve un json por http con mensaje de error
   * Usar cuando hay un error en la ejecucion de la peticion
   *
   * @param string $msg : El mensaje de error
   * @return application/json {success, title, message, type}
   */
  public static function jError($msg) {
    header('Content-Type: application/json');
    $json = ["success"=>false,"title"=>"Error!","message"=>$msg,"type"=>"error"];
    echo json_encode($json);
    die;
  }

  /**
   * Devuelve un json por http con mensaje de warning
   * Usar cuando hay que notificar al usuario de datos faltantes o alguna anomalia en los datos ingresados
   *
   * @param string $msg : El mensaje de warning
   * @return application/json {success, title, message, type}
   */
  public static function jWarning($msg) {
    header('Content-Type: application/json');
    $json = ["success"=>false,"title"=>"Error!","message"=>$msg,"type"=>"warning"];
    echo json_encode($json);
    die;
  }

  /**
   * Redirecciona al usuario a una pagina especificada
   *
   * @param string $ruta : ruta relativa del destino dentro del sistema
   * @return redirect
   */
  public static function redirect ($ruta) {
    header("Location: ".URLBASE.$ruta);
    die;
  }

  /**
   * Muestra una pagina de error 404
   *
   * @return view
   */
  public static function E404() {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: text/html');
    include ("./views/templates/404.html");
    die;
  }

  /**
   * Muestra una pagina de error 403
   *
   * @return view
   */
  public static function E403() {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/html');
    include ("./views/templates/403.html");
    die;
  }

  /**
   * Muestra una pagina de error 500
   *
   * @return view
   */
  public static function E500() {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: text/html');
    include ("./views/templates/500.html");
    die;
  }

}

?>
