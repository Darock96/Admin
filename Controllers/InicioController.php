<?php

namespace Controllers;

use Classes\Controller;
use Classes\Response;

class InicioController extends Controller {

  public function index() {
    return Response::view("modules/inicio/index");
  }

}

?>
