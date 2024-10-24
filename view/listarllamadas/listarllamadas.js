var daterange = localStorage.getItem("daterange");
var estado;
var campana = localStorage.getItem("fil_campana");
var agente = localStorage.getItem("fil_agente");
var idllamada;

function init() {
  estado = localStorage.getItem("botonSeleccionado");
  if (estado == "Interesado") {
    $("#title").html("Listado Llamadas - Interesado");
  } else if (estado == "Volver a llamar") {
    $("#title").html("Listado Llamadas - Volver a llamar");
  } else if (estado == "Buzon de voz") {
    $("#title").html("Listado Llamadas - Buzón de voz");
  } else if (estado == "sin") {
    $("#title").html("Listado Llamadas - Sin estado");
  } else if (estado == "No interesado") {
    $("#title").html("Listado Llamadas - No interesados");
  } else if (estado == "Numero Equivocado") {
    $("#title").html("Listado Llamadas - Números Equivocados");
  } else if (estado == "Fallecido") {
    $("#title").html("Listado Llamadas - Fallecidos ");
  } else if (estado == "Fuera de servicio") {
    $("#title").html("Listado Llamadas - Fuera de servicio");
  }
  // -------------------------------------------- 
  else if(estado == "Ilocalizado"){
    $("#title").html("Listado Llamadas - Ilocalizado");
  } else {
    $("#title").html("Listado Llamadas");
  }
}
$(document).ready(function () {
  listar();
});
function listar() {
  console.log(estado);
  var valores = {
    daterange: daterange,
    estado: estado,
    campana: campana,
    agente: agente,
  };

  var tabla = $("#ticket_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/llamada.php?op=listarllamadas",
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
      columnDefs: [
        {
          targets: [6], // El índice de la columna de fecha en tu tabla
          orderable: false, // Desactiva la ordenación para esta columna
        },
      ],
      order: [], // Desactiva la ordenación predeterminada
      initComplete: function (settings, json) {
        var responseData = json.aaData;
      },
    })
    .dataTable();
}
$(document).on("click", ".btn-inline", function () {
  estado = localStorage.getItem("botonSeleccionado");
  campanaestado = localStorage.getItem("ultimoTexto");

  idllamada = $(this).data("llamada");
  var [cli, camp] = idllamada.split(",");

  if(campanaestado == "Activa" || campanaestado == "Terminada" ){
    if (
      estado === "Volver a llamar" ||
      estado === "Buzon de voz" ||
      estado === "sin" ||
      estado === "Ilocalizado"
    ) {
      var detalle = "";
      if (estado === "Volver a llamar") {
        detalle = "VOLVER A LLAMAR";
      } else if (estado === "Buzon de voz") {
        detalle = "BUZON DE VOZ";
      } else if (estado === "sin") {
        detalle = "SIN ESTADO";
      }
      else if (estado === "Ilocalizado") {
        detalle = "ILOCALIZADO";
      }
      var estado = 1;
  
      $.post(
        "../../controller/reconsola.php?op=registrar",
        { campid: camp, detalle: detalle, estado: estado },
        function (data, status) {
          var queryParams = `?i=${idllamada}`;
          var href = "../consola/" + queryParams;
          window.location.href = href;
        }
      );
    } else {
      comentario();
    }
  }else{
    comentario();
  }  
});

function comentario(){
  $.ajax({
    url: "../../controller/llamada.php?op=Bcomentario",
    type: "POST",
    data: { id: idllamada },
    success: function (data) {
      data = JSON.parse(data);
      swal({
        title: "Comentario",
        text: data[0].OBSERVACIONES,
        confirmButtonClass: "btn-success",
      });
    },
  });
}

init();
