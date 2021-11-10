const langTable = {
  sProcessing:"Procesando...",
  sLengthMenu:"Mostrar _MENU_",
  sZeroRecords:"Sin resultados",
  sEmptyTable:"Sin resultados disponibles",
  sInfo:"_START_ al _END_ de _TOTAL_",
  sInfoEmpty:"Sin resultados",
  sInfoFiltered:"(filtrado de _MAX_)",
  sInfoPostFix:"",
  sSearch:"Buscar:",
  sUrl:"",
  sInfoThousands:",",
  sLoadingRecords:"Cargando...",
  oPaginate: {
    sFirst:"<<",
    sLast:">>",
    sNext:">",
    sPrevious:"<"
  },
  oAria: {
    sSortAscending:": Ordenar de manera ascendente",
    sSortDescending:": Ordenar de manera descendente"
  }
}

// Funcion sweetalert
function alerta(titulo, texto, tipo,txt){
  swal.fire({
    title: titulo,
    text: texto,
    icon: tipo,
    confirmButtonText: txt
  });
}

//html
function fromHTML(str) {
  if ( str == "" ) return "";
  let res = $.parseHTML(str);
  return res[0].data;
}
