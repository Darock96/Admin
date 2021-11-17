<?php
session_start();

require "./vendor/autoload.php";


/**
 * URL del sitio administrador
 * @var String
 */
define("URLBASE",$_ENV['URLBASE']);

/**
 * URL de la carpeta de recursos para el sitio web (imagenes, PDF, zip, etc)
 * @var String
 */
define("URLSRC",$_ENV['URLBASE']."resources/");

/**
 * Ruta al directorio de recursos para el sitio web (imagenes, PDF, zip, etc)
 * @var String
 */
define("DIRSRC",$_SERVER['DOCUMENT_ROOT']."/resources/");

/**
 * Codigos de error para archivos permitidos: [0,4]
 * @var Array
 */
define("ERR_FILE_ALLOWED",[0,4]);



$dotenv = Dotenv\Dotenv::createImmutable('./');
$dotenv->load();

//Verificamos el entorno para mostrar errores
if ( $_ENV['APP_ENV'] == 'dev' ) {
  ini_set('display_errors','1');
  ini_set('display_startup_errors','1');
  error_reporting(E_ALL);
} else {
  ini_set('display_errors','0');
  ini_set('display_startup_errors','0');
  error_reporting(0);
}

//Obtener parametros de la URL
$ControllerName = ( isset( $_GET['controller']) ) ? ucfirst($_GET['controller'])."Controller" : "LoginController" ;
$Action = ( isset( $_GET['action']) ) ? $_GET['action'] : "index" ;
$Param = ( isset( $_GET['parametro']) ) ? $_GET['parametro'] : "" ;

//Generar el nombre del controllador que se va a invocar
$ControllerPath = "Controllers\\".$ControllerName;

//Funcion de autoload de las clases a utilizar
spl_autoload_register(function($CLASS) {
  $RUTA = str_replace("\\","/",$CLASS).".php";
  if ( is_readable ( $RUTA) ) {
    require_once $RUTA;
  } else {
    Classes\Response::E404();
  }
});

//Invocar el Controlador y ejecutar la acción solicitada
$Controller = new $ControllerPath();

if ( !method_exists($Controller,$Action) ) Classes\Response::E404();

if ( $Param == "" ) $Controller->$Action();
else $Controller->$Action($Param);
?>
