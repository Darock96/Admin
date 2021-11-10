<head>
  <meta charset="utf-8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <title><?=$_ENV['APP_NAME']?></title>

  <link rel="shortcut icon" href="<?=$_ENV['URLBASE']?>assets/img/favicon.png"/>
  <link rel="stylesheet" href="<?=$_ENV['URLBASE']?>assets/css/styles.css"/>
  <link rel="stylesheet" href="<?=$_ENV['URLBASE']?>assets/css/uicons-regular-rounded.css"/>
  <link rel="stylesheet" href="<?=$_ENV['URLBASE']?>assets/plugins/sweetalert/sweetalert2.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>

  <script>
    const url='<?=$_ENV['URLBASE']?>';
  </script>

</head>

<body>
  <div class="wrapper">
    <?php include "./views/templates/menu.php";?>
    <div class="main_content">
      <div class="header">
        <?=$_ENV['APP_NAME']?>
        <a href="<?=$_ENV['URLBASE']?>login/salir" class="btn btn-secondary">Salir</a>
      </div>
      <div class="info">
