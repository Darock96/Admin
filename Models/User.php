<?php
namespace Models;

use Classes\Model;

class User extends Model {

  public function __construct ($DB) {
    parent::__construct($DB);
    $this->TABLA = "users";
  }

  public function existsByEmail($email) {
    $SQL = "SELECT COUNT(id) as cuantos FROM users WHERE email = '{$email}' ";
    $us = $this->DB->Consultar($SQL);
    return ($us[0]['cuantos'] > 0) ? true : false;
  }

  public function getUserLogin($email,$pass) {
    $SQL = "SELECT nombre, email, rol FROM users WHERE email = '{$email}' AND pass = '{$pass}' ";
    $us = $this->DB->Consultar($SQL);
    return (count($us) > 0) ? $us[0] : false;
  }

}
?>
