$(document).on("submit","form", (event) => {
  event.preventDefault();
  let form = $(this);
  let type = form.attr("method");
  let action = form.attr("action");
  let confirmar = form.data("confirmar");
  let data = null;

  if ( typeof(CKEDITOR) != 'undefined' ) {
    for ( var ck in CKEDITOR.instances ) {
      CKEDITOR.instances[ck].updateElement();
    }
  }

  data = ( type == "GET" || type == "get" ) ? form.serialize() : new FormData ( form[0] );

  if (confirmar) {

    let title = form.data('title');
    Swal.fire({
      title: title,
      text: "¿Los datos ingresados son correctos?",
      icon: "question",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        sendToServer(form,action,type,data);
      }
    });

  } else {
    sendToServer(form,action,type,data);
  }
});

function sendToServer(formulario, url, method, datos) {
  $.ajax({
    url:url,
    type:method,
    data:datos,
    cache:false,
    processData:false,
    contentType:false,
    beforeSend: () => DescButtons(formulario),
    complete: () => ActButtons(formulario),
    error: () => alerta ("Error","Ocurrió un error al conectarse con el servidor, inténtelo más tarde por favor","error","Aceptar"),
    success: ({success,title,message,type,evaluar = null}) => {
      alerta(title,message,type,"Aceptar");
      if ( success ) {
        formulario.trigger("reset");
        formulario.find("textarea").html("");
        eval(evaluar);
      }
    }
  });
}

//Botones de formularios
function DescButtons(f) {
  textBtn = f.find( "button[type='submit']" ).html();
  f.find( "button[type='submit']" ).html('');
  f.find( "button[type='submit']" ).html('<img width="50px" src="'+url+'assets/img/loading.gif">');
  f.find( "button[type='submit']" ).attr('disabled','disabled');
  f.find( "button[type='reset']" ).attr('disabled','disabled');
}

function ActButtons(f) {
  f.find( "button[type='submit']" ).html('');
  f.find( "button[type='submit']" ).html(textBtn);
  f.find( "button[type='submit']" ).prop('disabled',null);
  f.find( "button[type='reset']" ).prop('disabled',null);
}
