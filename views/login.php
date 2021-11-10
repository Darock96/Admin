<!DOCTYPE html>
<html lang="es">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$_ENV['APP_NAME']?></title>

    <link rel="shortcut icon" href="<?=$_ENV['URLBASE']?>assets/img/favicon.png">
    <link rel="stylesheet" href="<?=$_ENV['URLBASE']?>assets/css/login.css">
    <link rel="stylesheet" href="<?=$_ENV['URLBASE']?>assets/css/uicons-regular-rounded.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <script>const url='<?=$_ENV['URLBASE']?>';</script>
  </head>

  <body class="bg-login">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mt-3">
          <img src="<?=$_ENV['URLBASE']?>assets/img/logo.png" class="img-fluid" />
          <form class="text-center">
            <h2>Iniciar sesi&oacute;n</h2>
            <div class="form-group">
              <label class="required">Usuario</label>
              <input type="email" class="form-control" name="user" required/>
            </div>
            <div class="form-group">
              <label class="required">Contraseña</label>
              <input type="password" class="form-control" name="pass" required/>
            </div><hr/>
            <div class="alert"></div>
            <button class="btn btn-primary pull-rigth"><i class="fi-rr-sign-in"></i>&nbsp;&nbsp;Entrar</button><br/>
            <small><a href="#">Recuperar contraseña</a></small>
          </form>
        </div>
      </div>
    </div>

    <script src="<?=$_ENV['URLBASE']?>assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script src="<?=$_ENV['URLBASE']?>assets/js/login.js"></script>
  </body>

</html>
