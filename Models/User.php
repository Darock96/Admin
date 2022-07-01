<?php
namespace Models;

use Classes\Model;

/**
 * Modelo de usuarios del sistema
 *
 * @package Models
 * @uses table -> users
 * @author Daniel Oliveros
 */
class User extends Model {

  public function __construct ($DB) {
    parent::__construct($DB);
    $this->TABLA = "users";
    $this->PRKEY = "id_users";
  }

  /**
   * Verifica si la direcion de correo esta registrada en usuarios
   *
   * @param string $email
   * @return boolean
   */
  public function existsByEmail($email) {
    $SQL = "SELECT COUNT(id_users) as cuantos FROM users WHERE email = ? ";
    $us = $this->DB->ConsultaFila($SQL,[$email]);
    return ($us->cuantos > 0) ? true : false;
  }

  /**
   * Verifica si la direcion de correo esta registrada en usuarios y la contrasenna coincide
   *
   * @param string $email
   * @param string $pass -> en MD5
   * @return boolean
   */
  public function getUserLogin($email,$pass) {
    $SQL = "SELECT nombre, email, rol FROM users WHERE email = ? AND pass = ? ";
    $us = $this->DB->ConsultaFila($SQL,[$email,$pass]);
    return (!is_null($us)) ? $us : false;
  }

}
?>
