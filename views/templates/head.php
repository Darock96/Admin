<head>
  <meta charset="utf-8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <title><?=$_ENV['APP_NAME']?></title>

  <link rel="shortcut icon" href="<?=URLBASE?>assets/img/favicon.png"/>
  <link rel="stylesheet" href="<?=URLBASE?>assets/css/styles.css"/>
  <link rel="stylesheet" href="<?=URLBASE?>assets/css/uicons-regular-rounded.css"/>
  <link rel="stylesheet" href="<?=URLBASE?>assets/plugins/sweetalert/sweetalert2.min.css"/>
  <link rel="stylesheet" href="<?=URLBASE?>assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="<?=URLBASE?>assets/css/bootstrap-icons.css"/>

  <script>
    const url='<?=URLBASE?>';
    const urlsrc='<?=URLSRC?>';
  </script>

</head>

<body>
  <div class="wrapper">
    <?php include "./views/templates/menu.php";?>
    <div class="main_content">
      <div class="header">
        <?=$_ENV['APP_NAME']?>
        <a href="<?=URLBASE?>login/salir" class="btn btn-secondary">Salir</a>
      </div>
      <div class="info">
