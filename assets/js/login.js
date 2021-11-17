$("form").submit( function (e) {
  e.preventDefault();
  let data = $(this).serialize();
  $("button, input").prop("disabled","disabled");
  $(".alert").removeClass("alert-danger");
  $.post( url+"login/login", data, ( {success, msg} ) => {
    if ( success ) {
      $(".alert").addClass("alert-success");
      $(".alert").html("<h3>Acceso correcto!</h3>");
      setTimeout( () => location.href=url+"inicio", 2500 );
    } else {
      $(".alert").addClass("alert-danger");
      $(".alert").html("<h3>Acceso incorrecto!</h3><p>"+msg+"</p>");
    }
  }).fail( () => {
    $(".alert").addClass("alert-danger");
    $(".alert").html("<h3>Ocurri&oacute; un error</h3><p>No fue posible conectarse con el servidor, int&eacute;nte m&aacute;s tarde por favor</p>");
  }).always( () => $("button, input").prop("disabled",null));
});
