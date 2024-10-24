var tabla;

function init() {}

$(document).ready(function () {});
$("#filtros_busqueda").on("submit", function (e) {
  busqueda(e);
});

function busqueda(e) {
  e.preventDefault();
  var grupo;
  var filtro = $("#filtroB").val();
  var busqueda = $("#busqueda").val();
  if (
    usu_grupocom == 0 ||
    usu_grupocom == null ||
    usu_grupocom == undefined ||
    usu_grupocom == ""
  ) {
    grupo = 0;
  } else {
    grupo = usu_grupocom;
  }

  var valores = {
    grupo: grupo,
    usu_id: usu_id,
    usuPerfil: usuPerfil,
    filtro: filtro,
    busqueda: busqueda,
  };

  tabla = $("#ticket_data").dataTable({
    aProcessing: true,
    aServerSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ajax: {
      url: "../../controller/cliente.php?op=buscarxDato",
      type: "post",
      dataType: "json",
      data: valores,
      error: function (e) {
        swal("Error", e.responseText, "error");
      },
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 10,
    autoWidth: false,
    language: {
      sProcessing: "Procesando...",
      sLengtMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando un total de 0 registros",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          "Activar para ordenar la columna de manera descendente",
      },
    },
  });
}

$("#btntodo").on("click", function () {
  $("#busqueda").val("");

  if (tabla) {
    tabla.DataTable().clear().draw();
  }
});

$(document).on("click", ".btn-inline", function () {
  const cliente = $(this).data("cliente");
  var queryParams = `?i=${cliente}`;
  var href = "../detallecliente/" + queryParams;
  window.location.href = href;
});

init();
