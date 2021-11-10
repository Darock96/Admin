<?php

namespace Classes;

class Response {

  //Retornar una vista HTML
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

  public static function json($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    die;
  }

  public static function jExito($msg,$final) {
    header('Content-Type: application/json');
    $json = ["success"=>true,"title"=>"Éxito!","message"=>$msg,"type"=>"success","evaluar"=>$final];
    echo json_encode($json);
    die;
  }

  public static function jError($msg) {
    header('Content-Type: application/json');
    $json = ["success"=>false,"title"=>"Error!","message"=>$msg,"type"=>"error"];
    echo json_encode($json);
    die;
  }

  public static function jWarning($msg) {
    header('Content-Type: application/json');
    $json = ["success"=>false,"title"=>"Error!","message"=>$msg,"type"=>"warning"];
    echo json_encode($json);
    die;
  }

  public static function redirect ($ruta) {
    header("Location: ".$_ENV['URLBASE'].$ruta);
    die;
  }

  public static function E404() {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: text/html');
    include ("./views/templates/404.html");
    die;
  }

  public static function E403() {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/html');
    include ("./views/templates/403.html");
    die;
  }

  public static function E500() {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: text/html');
    include ("./views/templates/500.html");
    die;
  }

}

?>
