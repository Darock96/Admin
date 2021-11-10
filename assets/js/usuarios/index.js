var tabla = null;

//Llenar tabla
$( () => {
  tabla = $("#resultados").DataTable({
    processing: true,
    serverSide: true,
    stateSave: true,
    ajax: {
      type: "GET",
      url : url + "usuarios/getTabla"
    },
    stateSaveCallback: (settings,data) => localStorage.setItem("DataTables_"+settings.sInstance, JSON.stringify(data)),
    stateLoadCallback: (settings) => JSON.parse( localStorage.getItem("DataTables_"+settings.sInstance)),
    columns : [
      { data: 'usuario', name: 'nombre' },
      { data: 'email', name: 'email' },
      { data: 'rol', name: 'rol' },
      { data: 'activo', name: 'activo' },
      { data: 'opciones', searchable:false, orderable:false },
    ],
    language: langTable
  });
});

//Cargar informacion del usuario para editar
$(document).on("click",".fi-rr-edit",() => {
  let key = $(this).data("id");
  let form = $("#editar");
  $("#nuevo").hide();
  form.show();
  $.get(url+"usuarios/get/"+key, ({id,nombre,email,rol}) => {
    form.find("input[name='id']").val(id);
    form.find("input[name='nombre']").val(fromHTML(nombre));
    form.find("input[name='mail']").val(email);
    form.find("select").val(rol);
  });
});

//Activar o desactivar usuario
$(document).on("click",".act",() => {
  let id = $(this).data("id");
  let estado = $(this).data("estado");
  let mensaje = ( estado ) ? "Desactivar" : "Activar" ;

  Swal.fire({
    title: "¿"+mensaje+" usuario?",
    icon: "question",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    confirmButtonText: mensaje,
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      $.get(url+"usuarios/cambiarestado/"+id, ({title,message,type}) =>  {
        alerta(title,message,type,"Aceptar");
        tabla.ajax.reload();
      });
    }
  });
});

//Eliminar usuario
$(document).on("click",".fi-rr-trash",() => {
  let id = $(this).data("id");

  Swal.fire({
    title: "¿Eliminar usuario?",
    text: "El usuario desaparecerá completamente del sistema",
    icon: "question",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    confirmButtonText: "Eliminar",
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      $.get(url+"usuarios/delete/"+id, ({title,message,type}) => {
        alerta(title,message,type,"Aceptar");
        tabla.ajax.reload();
      });
    }
  });
});
