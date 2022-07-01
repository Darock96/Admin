<?php

namespace Controllers;

use Classes\Controller;
use Classes\DataTables;
use Classes\Response;
use Classes\DBManager;
use Models\User;

/**
 * SliderController
 *
 * CRUD de Usuarios del sistema
 *
 * @package Controllers
 * @author Daniel Oliveros
 */
class UsuariosController extends Controller {

  public function __construct() {
    if ( $_SESSION['user']->rol != 1 ) return Response::E403();
  }

  public function index() {
    return Response::view("modules/usuarios/index");
  }

  public function insert() {
    //Verificamos que el usuario no existe en el sistema
    $Users = new User(new DBManager);
    $existe = $Users->existsByEmail(addslashes($_POST['mail']));
    if ( $existe ) return Response::jWarning("El correo electrónico ya está asociado a una cuenta.");

    // Asignamos valores a los campos a insertar
    $_ins =  [
      'nombre' => $this->convertToHTML($_POST['nombre']),
      'email' => addslashes($_POST['mail']),
      'pass' => md5($_POST['pass']),
      'rol' => $_POST['rol'],
    ];

    // Se inserta el nuevo usuario y se devuelve el mensaje de listo o error
    $listo = $Users->insert($_ins);
    if ($listo) return Response::jExito("El usuario ha sido agregado correctamente.","tabla.ajax.reload()");
    else return Response::jError("Ocurrió un error al guardar el usuario.");
  }

  public function update() {
    $id = $_POST['id'];

    //Verificamos que el usuario no está duplicado en el sistema
    $Users = new User(new DBManager);
    $email = addslashes($_POST['mail']);
    $SQL = "SELECT COUNT(id_users) as cuantos FROM users WHERE email = ? AND id_users != ? ";
    $us = $Users->DB->ConsultaFila($SQL,[$email,$id]);
    if ( $us->cuantos > 0 ) return Response::jWarning("El correo electrónico ya está asociado a una cuenta.");

    // Asignamos valores a los campos a actualizar
    $_upd =  [
      'nombre' => $this->convertToHTML($_POST['nombre']),
      'email' => $email,
      'rol' => $_POST['rol'],
    ];

    if ( !empty ($_POST['pass']) ) $_upd['pass'] = md5($_POST['pass']);

    // Actualizar usuario y se devuelve el mensaje de listo o error
    $listo = $Users->update($_upd,$id);
    if ($listo) return Response::jExito("El usuario ha sido actualizado correctamente.",'tabla.ajax.reload();$("#editar").hide();$("#nuevo").show();');
    else return Response::jError("Ocurrió un error al actualizar el usuario.");
  }

  //Devuelve un elemento desde el id
  public function get( $ID ) {
    $Users = new User(new DBManager);
    $user = $Users->getById($ID);
    $user->pass = null;
    return Response::json($user);
  }

  //Activar o desactivar usuario
  public function cambiarestado ( $id ) {
    $Users = new User(new DBManager);
    $user = $Users->getById($id);
    $_upd['activo'] = ( $user->activo ) ? 0 : 1;
    $action = ( $user->activo ) ? "desactivado" : "activado";

    $bool = $Users->update($_upd,$id);
    if ($bool) return Response::jExito("El usuario ha sido {$action} correctamente.","tabla.ajax.reload()");
    else return Response::jError("Ocurrió un error al actualizar el usuario.");
  }

  //Eliminar usuario
  public function delete ( $id ) {
    $Users = new User(new DBManager);
    //Se elimina
    $bool = $Users->delete($id);
    if ($bool) return Response::jExito("El usuario ha sido eliminado correctamente.","tabla.ajax.reload()");
    else return Response::jError("Ocurrió un error al eliminar usuario.");
  }

  //Procesa peticion GET para devolver un JSON al plugin de DataTable
  public function getTabla () {
    $Cols = [
      'id' => 'id_users',
      'nombre' => 'nombre',
      'correo' => 'email',
      'activo' => 'activo',
      'rol' => 'rol'
    ];

    $DataTables = new DataTables;
    $DataTables->setTabla('users');
    $DataTables->setColumnas($Cols);
    $DataTables->setRequest($_GET);
    $tabla = $DataTables->getTabla();
    return Response::json($tabla);
  }

}

?>
