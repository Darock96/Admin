<!DOCTYPE html>
<html>
<?php include "./views/templates/head.php";?>

<link rel="stylesheet" href="<?=$_ENV['URLBASE']?>assets/plugins/datatables/css/datatables.min.css"/>

<h1>Usuarios</h1>

<div class="row">

  <div class="col-lg-8 col-sm-12">
    <table class="table table-stripped" id="resultados">
      <thead class="table-dark">
        <th>Usuario</th>
        <th>E-Mail</th>
        <th>Rol</th>
        <th>Activo</th>
        <th>Opciones</th>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <div class="col-lg-4 col-sm-12">
    <form action="<?=$_ENV['URLBASE']?>usuarios/insert" method="POST" autocomplete="off" id="nuevo">
      <fieldset>
        <legend>Agregar un usuario</legend>
        <div class="form-group">
          <label class="required">Nombre de usuario</label>
          <input type="text" class="form-control" name="nombre" required/>
        </div>
        <div class="form-group">
          <label class="required">Correo electr&oacute;nico</label>
          <input type="email" class="form-control" name="mail" required/>
        </div>
        <div class="form-group">
          <label class="required">Tipo de usuario</label>
          <select class="form-control" name="rol" required>
            <option value="">Seleccione una opcion</option>
            <option value="1">Administrador</option>
            <option value="2">Sitio web</option>
            <option value="3">Tienda</option>
          </select>
        </div>
        <div class="form-group">
          <label class="required">Contrase&ntilde;a</label>
          <input type="password" class="form-control" name="pass" required/>
        </div>
        <div class="form-group">
          <hr/>
          <button class="btn btn-primary" type="submit"><i class="fi-rr-disk"></i>&nbsp;&nbsp;Guardar</button>
          <button class="btn btn-secondary" type="reset"><i class="fi-rr-cross"></i>&nbsp;&nbsp;Cancelar</button>
        </div>
      </fieldset>
    </form>

    <form action="<?=$_ENV['URLBASE']?>usuarios/update" method="POST" autocomplete="off" id="editar" style="display:none;">
      <fieldset>
        <legend>Actualizar usuario</legend>
        <div class="form-group">
          <label class="required">Nombre de usuario</label>
          <input type="hidden" name="id" required/>
          <input type="text" class="form-control" name="nombre" required/>
        </div>
        <div class="form-group">
          <label class="required">Correo electr&oacute;nico</label>
          <input type="email" class="form-control" name="mail" required/>
        </div>
        <div class="form-group">
          <label class="required">Tipo de usuario</label>
          <select class="form-control" name="rol" required>
            <option value="">Seleccione una opcion</option>
            <option value="1">Administrador</option>
            <option value="2">Sitio web</option>
            <option value="3">Tienda</option>
          </select>
        </div>
        <div class="form-group">
          <label>Contrase&ntilde;a</label>
          <input type="password" class="form-control" name="pass"/>
        </div>
        <div class="form-group">
          <hr/>
          <button class="btn btn-primary" type="submit"><i class="fi-rr-disk"></i>&nbsp;&nbsp;Guardar</button>
          <button class="btn btn-secondary" type="reset" onclick="$('#editar').hide();$('#nuevo').show();"><i class="fi-rr-cross"></i>&nbsp;&nbsp;Cancelar</button>
        </div>
      </fieldset>
    </form>
  </div>

</div>

<?php include "./views/templates/footer.php";?>

<!-- Area scripts locales -->
<script src="<?=$_ENV['URLBASE']?>assets/plugins/datatables/js/datatables.min.js"></script>
<script src="<?=$_ENV['URLBASE']?>assets/js/usuarios/index.js"></script>
<script src="<?=$_ENV['URLBASE']?>assets/js/formularios.js"></script>

</html>
