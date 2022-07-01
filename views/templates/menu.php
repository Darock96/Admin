<!-- Sidebar -->
<div class="sidebar">
  <h2><a href="<?=URLBASE?>inicio"><i class="fi-rr-home"></i>&nbsp;Admin</a></h2>
  <ul>
    <li <?php if ( $_GET['controller'] == 'inicio' ) { echo 'class="active"'; } ?>><a href="<?=URLBASE?>inicio"><i class="fi-rr-rocket"></i>&nbsp;Dashboard</a></li>
    <?php if ( $_SESSION['user']->rol == 1): ?>
    <li <?php if ( $_GET['controller'] == 'usuarios' ) { echo 'class="active"'; } ?>><a href="<?=URLBASE?>usuarios"><i class="fi-rr-user"></i>&nbsp;Usuarios</a></li>
    <?php endif; ?>

    <?php if ( $_SESSION['user']->rol == 2 OR $_SESSION['user']->rol == 1): ?>
    <h4>Contenido</h4>
    <li <?php if ( $_GET['controller'] == 'slider' ) { echo 'class="active"'; } ?>><a href="<?=URLBASE?>slider"><i class="fi-rr-picture"></i>&nbsp;Slider</a></li>
    <?php endif; ?>

    <?php if ( $_SESSION['user']->rol == 3 OR $_SESSION['user']->rol == 1): ?>
    <h4>Tienda</h4>
    <?php endif; ?>
  </ul>
</div>
<!-- /#sidebar-wrapper -->
