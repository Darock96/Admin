<?php

namespace Classes;

/**
 * Controller
 *
 * Contiene Metodos para limpiar y convertir texto a un estandar del sistema
 *
 * @package Classes
 * @author Daniel Oliveros
 */
class Controller {

  private $ACT = array(
    "!","\"","$","%","'","(",")","*","+",",","-",".","/",":","<","=",">","?","@",
    "[","\\","]","^","_","`","{","|","}","~",
    "¡","¢","£","¤","¥","¦","§","¨","©","ª","«","¬","®","¯",
    "°","±","²","³","´","µ","¶","·","¸","¹","º","»","¼","½","¾","¿",
    "À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï",
    "Ð","Ñ","Ò","Ó","Ô","Õ","Ö","×","Ø","Ù","Ú","Û","Ü","Ý","Þ","ß",
    "à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï",
    "ð","ñ","ò","ó","ô","õ","ö","÷","ø","ù","ú","û","ü","ý","þ","ÿ",
    "Œ","œ","Š","š","Ÿ","ƒ",
    "–","—","‘","’","‚","“","”","„","†","‡","•","…","‰","€","™"
  );

  private $CLN = array(
    "&#33;","&#34;","&#36;","&#37;","&#39;","&#40;","&#41;","&#42;","&#43;","&#44;","&#45;","&#46;","&#47;","&#58;","&#60;","&#61;","&#62;","&#63;","&#64;",
    "&#91;","&#92;","&#93;","&#94;","&#95;","&#96;","&#123;","&#124;","&#125;","&#126;",
    "&#161;","&#162;","&#163;","&#164;","&#165;","&#166;","&#167;","&#168;","&#169;","&#170;","&#171;","&#172;","&#174;","&#175;",
    "&#176;","&#177;","&#178;","&#179;","&#180;","&#181;","&#182;","&#183;","&#184;","&#185;","&#186;","&#187;","&#188;","&#189;","&#190;","&#191;",
    "&#192;","&#193;","&#194;","&#195;","&#196;","&#197;","&#198;","&#199;","&#200;","&#201;","&#202;","&#203;","&#204;","&#205;","&#206;","&#207;",
    "&#208;","&#209;","&#210;","&#211;","&#212;","&#213;","&#214;","&#215;","&#216;","&#217;","&#218;","&#219;","&#220;","&#221;","&#222;","&#223;",
    "&#224;","&#225;","&#226;","&#227;","&#228;","&#229;","&#230;","&#231;","&#232;","&#233;","&#234;","&#235;","&#236;","&#237;","&#238;","&#239;",
    "&#240;","&#241;","&#242;","&#243;","&#244;","&#245;","&#246;","&#247;","&#248;","&#249;","&#250;","&#251;","&#252;","&#253;","&#254;","&#255;",
    "&#338;","&#339;","&#352;","&#353;","&#376;","&#402;",
    "&#8211;","&#8212;","&#8216;","&#8217;","&#8218;","&#8220;","&#8221;","&#8222;","&#8224;","&#8225;","&#8226;","&#8230;","&#8240;","&#8364;","&#8482;"
  );

  /**
   * Convertir texto a entidades HTML
   *
   * @param string $texto
   * @return string en HTML
   */
  public function convertToHTML($texto) {
    $TXT = trim($texto);
    $TXT = str_replace($this->ACT,$this->CLN,$TXT);
    $TXT = preg_replace("/[\n|\r|\r\n]+/","<br>",$TXT);
    return $TXT;
  }

  /**
   * Elimina o convierte caracteres a una version aceptable como URL limpia
   *
   * @param string $texto
   * @return string
   */
  public function makeURL($texto) {
    $chr = "/[^a-zA-Z0-9-]+/";
    $acl = array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ',' ');
    $vcl = array('a','e','i','o','u','n','A','E','I','O','U','N','-');
    $url = trim($texto);
    $url = str_replace($acl,$vcl,$url);
    $url = preg_replace($chr,'',$url);
    $url = preg_replace("/-+/",'-',$url);
    $url = strtolower($url);
    return $url;
  }

  /**
   * Elimina la extension de un nombre de archivo
   *
   * @param $texto
   * @return string
   */
  public function makeNombre($texto) {
    $T = explode(".",$texto);
    array_pop($T);
    $texto = implode('.',$T);
    return $texto;
  }

  /**
   * Devuelve la extension de un nombre de archivo
   *
   * @param $texto
   * @return string: ".ext"
   */
  private function getExtension($nombre) {
    $nom = explode('.',$nombre);
    $l = count($nom) - 1;
    return ".".$nom[$l];
  }

  /**
   * Generar una URL valida como nombre de archivo
   *
   * @param $NFILE
   * @return string: "file.ext"
   */
  public function makeURLFILE($NFILE) {
    $N = $this->makeNombre($NFILE);
    $NOM = $this->makeURL($N);
    $EXT = $this->getExtension($NFILE);
    $FILENAME = $NOM.$EXT;
    return $FILENAME;
  }

  /**
   * Devuelve el mensaje de error correspondiente a $_FILES
   *
   * @param int $ERROR
   * @return string
   */
  private function getFileErrorMSG($ERROR) {
    $MSG = "";
    switch ($ERROR) {
    case 0: $MSG = "El archivo se ha subido correctamente"; break;
    case 1: $MSG = "El archivo es demasiado grande para subirlo al servidor."; break;
    case 2: $MSG = "El archivo es damasiado grande para procesarlo."; break;
    case 3: $MSG = "El archivo no se ha subido completamente."; break;
    case 4: $MSG = "No se ha subido ningún archivo"; break;
    case 6: $MSG = "Se ha perdido la ubicación temporal del archivo"; break;
    case 7: $MSG = "No se pudo escribir su archivo en el servidor"; break;
    case 8: $MSG = "Un módulo de php ha detenido la carga del archivo"; break;
    default: $MSG = "Error de imagen desconocido"; break;
    }
    return $MSG;
  }

  /**
   * Subir un archivo a la ruta especificada
   *
   * @param array $file : Fl objeto de $_FILES para el archivo ej => $_FILES['imagen']
   * @param string $dir : Directorio donde se guarda el archivo
   * @param string $name : Opcional nombre del archivo sin extension
   * @return [error,'filename' OR 'message']
   */
  public function uploadfile($file,$dir,$name="") {
    $folder = DIRSRC.$dir;
    if ( $file['error'] == 0 ) {
      $filename = ( $name == "" ) ? $_ENV['PREFIX'].$this->makeURLFILE($file['name']) : $_ENV['PREFIX'].$name.$this->getExtension($file['name']);
      move_uploaded_file($file['tmp_name'],$folder.$filename);
      return ["error"=>0,"filename"=>$filename];
    } else return ["error"=>$file['error'],"message"=>$this->getFileErrorMSG($file['error'])];
  }

}
?>
