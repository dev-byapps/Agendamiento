var daterange;
var usu_perfil;
var fil_entidad;
var fil_grupo;
var fil_asesor;
var estado;
var filtro;

function init() {}

$(document).ready(function () {
  daterange = localStorage.getItem("daterange");
  usu_perfil = localStorage.getItem("usu_perfil");
  fil_entidad = localStorage.getItem("fil_entidad");
  fil_grupo = localStorage.getItem("fil_grupo");
  fil_asesor = localStorage.getItem("fil_asesor");
  estado = localStorage.getItem("botonSeleccionado");
  filtro = localStorage.getItem("filtro");

  var letra = "S";
  if (estado == "Analisis") {
    letra = "";
  } else if (estado == "Operacion") {
    letra = "ES";
  }
  var nombre = "Listado " + estado.toUpperCase() + letra;
  $("#titulo").text(nombre);

  listar();
});
function listar() {
  $("#ticket_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: true,
    lengthChange: false,
    colReorder: true,
    ordering: false,
    ajax: {
      url: "../../controller/cliente.php?op=listar",
      type: "post",
      dataType: "json",
      data: {
        daterange: daterange,
        usu_perfil: usu_perfil,
        fil_entidad: fil_entidad,
        fil_grupo: fil_grupo,
        fil_asesor: fil_asesor,
        estado: estado,
        filtro: filtro,
      },
      error: function (e) {
        swal(e.responseText);
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
    columnDefs: [
      {
        targets: [7], // El índice de la columna de fecha en tu tabla
        orderable: false, // Desactiva la ordenación para esta columna
      },
    ],
    order: [], // Desactiva la ordenación predeterminada
  });
}
$(document).on("click", ".btn-inline", function () {
  const client = $(this).data("client");
  var queryParams = `?i=${client}`;
  var href = "../detallecliente/" + queryParams;
  window.location.href = href;
});
init();
