var tabla = null;

//Llenar tabla
$( () => {
  tabla = $("#resultados").DataTable({
    language: langTable,
    processing: true,
    serverSide: true,
    stateSave: true,
    ajax: {
      type: "GET",
      url : `${url}usuarios/getTabla`
    },
    stateSaveCallback: (settings,data) => localStorage.setItem("DataTables_"+settings.sInstance, JSON.stringify(data)),
    stateLoadCallback: (settings) => JSON.parse( localStorage.getItem("DataTables_"+settings.sInstance)),
    columns : [
      { data: 'nombre', name: 'nombre' },
      { data: 'correo', name: 'correo' },
      { 
        data: 'rol',name: 'rol',
        render: (data,type,row) => {
          const roles = {1:"Administrador",2:"Contenido",3:"Tienda"};
          return roles[row.rol];
        }
      },
      {
        data: 'activo',name: 'activo',
        render: (data,type,row) => {
          const texto = ["Inactivo","Activo"];
          const clase = ["danger","success"];
          return '<button class="btn btn-'+clase[row.activo]+' act" data-id="'+row.id+'" data-estado="'+row.activo+'">'+texto[row.activo]+'</button>';
        }
      },
      {
        data: 'id', searchable:false, orderable:false,
        render: (data,type,row) => '<i class="fi-rr-edit" data-id="'+row.id+'"></i>&nbsp;&nbsp;<i class="fi-rr-trash" data-id="'+row.id+'"></i>'
      },
    ],
  });
});

//Cargar informacion del usuario para editar
$(document).on("click",".fi-rr-edit", function() {
  let key = $(this).data("id");
  let form = $("#editar");
  $("#nuevo").hide();
  form.show();
  $.get(`${url}usuarios/get/${key}`, ({id_users,nombre,email,rol}) => {
    form.find("input[name='id']").val(id_users);
    form.find("input[name='nombre']").val(fromHTML(nombre));
    form.find("input[name='mail']").val(email);
    form.find("select").val(rol);
  });
});

//Activar o desactivar usuario
$(document).on("click",".act", function() {
  let id = $(this).data("id");
  let estado = $(this).data("estado");
  let mensaje = ( estado ) ? "Desactivar" : "Activar" ;

  Swal.fire({
    title: `¿${mensaje} usuario?`,
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
      $.get(`${url}usuarios/cambiarestado/${id}`, ({title,message,type}) =>  {
        alerta(title,message,type,"Aceptar");
        tabla.ajax.reload();
      });
    }
  });
});

//Eliminar usuario
$(document).on("click",".fi-rr-trash", function() {
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
      $.get(`${url}usuarios/delete/${id}`, ({title,message,type}) => {
        alerta(title,message,type,"Aceptar");
        tabla.ajax.reload();
      });
    }
  });
});
