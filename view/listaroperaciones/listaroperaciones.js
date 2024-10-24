var daterange;
var usu_perfil;
var fil_entidad;
var fil_grupo;
var fil_asesor;
var estado;

function init() {}

$(document).ready(function () {
  daterange = localStorage.getItem("daterange");
  usu_perfil = localStorage.getItem("usu_perfil");
  fil_entidad = localStorage.getItem("fil_entidad");
  fil_grupo = localStorage.getItem("fil_grupo");
  fil_asesor = localStorage.getItem("fil_asesor");
  estado = localStorage.getItem("botonSeleccionado");
  filtro = localStorage.getItem("filtro");

  var letra = "";
  if (estado == "Radicacion") {
    letra = "Listado RADICACIONES";
    $("#tltfech").text("Fecha Radicación");
  } else if (estado == "Proceso") {
    letra = "Listado EN PROCESOS";
    $("#tltfech").text("Fecha Radicación");
  } else if (estado == "Devolucion") {
    letra = "Listado DEVOLUCIONES";
    $("#tltfech").text("Fecha Radicación");
  } else if (estado == "Negado") {
    letra = "Listado NEGADOS";
    $("#tltfech").text("Fecha Cierre");
  } else if (estado == "Desembolsado") {
    letra = "Listado DESEMBOLSADOS";
    $("#tltfech").text("Fecha Cierre");
  }
  $("#titulo").text(letra);

  listar();
});
function listar() {
  var tabla = $("#ticket_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/operacion.php?op=listarOpe",
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
    })
    .dataTable();
}
$(document).on("click", ".btn-inline", function () {
  const ope = $(this).data("ope");
  var queryParams = `?i=${ope}`;
  var href = "../detallecliente/" + queryParams;
  window.location.href = href;
});

init();
