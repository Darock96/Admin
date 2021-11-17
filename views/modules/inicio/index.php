<!DOCTYPE html>
<html>
<?php include "./views/templates/head.php";?>

<?php if( $_SESSION['user']['rol'] == 1 ): ?>
<h1>Administrador</h1>
<div class="row">
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="dashboard-block dark">
      <a href="<?=URLBASE?>usuarios">
        <h2><i class="fi-rr-user"></i>&nbsp;&nbsp;Usuarios</h2>
      </a>
    </div>
  </div>
</div>
<?php endif; ?>


<?php if( $_SESSION['user']['rol'] == 1 || $_SESSION['user']['rol'] == 2 ): ?>
<h1>Contenido web</h1>
<div class="row">
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="dashboard-block dark">
      <a href="<?=URLBASE?>slider">
        <h2><i class="fi-rr-picture"></i>&nbsp;&nbsp;Slider</h2>
      </a>
    </div>
  </div>
</div>

<?php endif; ?>


<?php if( $_SESSION['user']['rol'] == 1 || $_SESSION['user']['rol'] == 2 ): ?>
<h1>Tienda</h1>
<div class="row">

</div>

<?php endif; ?>


<?php include "./views/templates/footer.php";?>

<!-- Area scripts locales -->

</html>
