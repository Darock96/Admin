<?php

namespace Controllers;

use Classes\Controller;
use Classes\DBManager;
use Classes\Response;

use Models\User;

class LoginController extends Controller {

  public function index() {
    return Response::view("login");
  }

  public function login () {
    $exito = ["success" => true];
    $error = ["success" => false];

    //Limpiamos la entrada para seguridad de la base de datos
    $Usuarios = new User(new DBManager);
    $email = addslashes($_POST['user']);
    $pass = md5($_POST['pass']);

    //Revisamos si existe el usuario
    if ( !$Usuarios->existsByEmail($email) ) {
      $error["msg"] = "El usuario no existe en el sistema.";
      return Response::json($error);
    }

    //Revisamos si la contraseña es correcta
    $user = $Usuarios->getUserLogin($email,$pass);
    if ( !is_array($user) ) {
      $error["msg"] = "Revise su contrase&ntilde;a por favor.";
      return Response::json($error);
    }

    $_SESSION['user'] = $user;
    return Response::json($exito);
  }

  public function salir () {
    session_unset();
    return Response::redirect("login");
  }

}

?>
