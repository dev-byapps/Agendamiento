var campana;
var botonSeleccionado;

function init() {
  listaragenda();
}
$(document).ready(function () {
  $('#fil_campana').select2({
    templateResult: formatOption,  // Función para personalizar la visualización de las opciones
    templateSelection: formatOption  // Función para personalizar la visualización de la opción seleccionada
  });

  Promise.all([listarcampanas(), listaragente()]).then(() => {
    $("#btnfiltrar").prop("disabled", false);
  });

  $("#btnfiltrar").on("click", function (e) {
    e.preventDefault();
    filtrar();
  });
});
function listaragenda() {
  var tabla = $("#agenda_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/llamada.php?op=listaragenda",
        type: "post",
        dataType: "json",
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
      order: [], // Desactiva la ordenación predeterminada
      initComplete: function (settings, json) {
        var responseData = json.aaData;
      },
    })
    .dataTable();
}
function listarcampanas() {
  return new Promise((resolve, reject) => {
    if (
      perfil == "Administrador" ||
      perfil == "Gerencia" ||
      perfil == "RRHH"
    ) {
      $.ajax({
        url: "../../controller/campana.php?op=todasCampanasActivas",
        type: "POST",
        data: {},
        success: function (datos) {
          if (datos.trim() === "") {
            $("#fil_campana").append(
              $("<option>", {
                value: "0",
                text: "No hay campañas disponibles",
                selected: true,
              })
            );
          } else {
            $("#fil_campana").html(datos);
          }
          resolve();
        },
        error: function (err) {
          reject(err);
        },
      });
    } else {
      $.ajax({
        url: "../../controller/campana.php?op=campanas",
        type: "POST",
        data: { usu_id: usu_id },
        success: function (datos) {
          var data = JSON.parse(datos);
          if (data[0].rcampanas.trim() === "") {
            $("#fil_campana").append(
              $("<option>", {
                value: "0",
                text: "No hay campañas disponibles",
                selected: true,
              })
            );
          } else {
            var rcampanasArray = data[0].rcampanas.split(", ");
            $("#fil_campana").empty();

            rcampanasArray.forEach(function (campana, index) {
              var campanaParts = campana.split(":");

              if (campanaParts.length === 3) {
                var campanaName = campanaParts[0].trim();
                var campanaId = campanaParts[1].trim();
                var estado = campanaParts[2].trim();
                var color = "";

                if(estado == 1){
                    estado = "Activa";
                }else if(estado == 2){
                    estado = "Inactiva";
                }else if(estado == 3){
                    estado = "Completada";
                }else if(estado == 4){
                    estado = "Cierre completo";
                }else if(estado == 5){
                    estado = "Terminada";
                }

                $("#fil_campana").append(
                  $("<option>", {
                    value: campanaId,
                    text: campanaName + " - " + estado,
                    selected: index === 0,
                  })
                );
              }
            });
          }
          resolve();
        },
        error: function (err) {
          reject(err);
        },
      });
    }
  });
}
function filtrar() {
  campana = $("#fil_campana").val();
  var texto = $("#fil_campana option:selected").text();
  var ultimoTexto = texto.split('-').pop().trim();
  localStorage.setItem("ultimoTexto", ultimoTexto);


  if (campana == 0 || campana == "" || campana == null) {
  } else {
    var formData = new FormData($("#filtros_form")[0]);

    localStorage.setItem("daterange", $("#daterange").val());
    localStorage.setItem("fil_campana", campana);
    localStorage.setItem("fil_agente", $("#fil_agente").val());

    $.ajax({
      url: "../../controller/llamada.php?op=dashagente",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        data = JSON.parse(datos);

        $.each(data, function (index, item) {
          console.log(item);
          $("#" + item.estado).html(item.cantidad);
        });
      },
    });
  }
}
$(document).on("click", ".btn-inline", function () {
  const agenda = $(this).data("agenda"); // Obtén el valor de data-agenda
  var [cli, camp] = agenda.split(","); // Divide usando '|' como separador
  var detalle = "AGENDA";
  var estado = 1;
  $.post(
    "../../controller/reconsola.php?op=registrar",
    { campid: camp, detalle: detalle, estado: estado },
    function (data, status) {
      var queryParams = `?i=${agenda}`;
      var href = "../consola/" + queryParams;
      window.location.href = href;
    }
  );
});
function formatOption(option) {
  if (!option.id) {
    return option.text;
  }
  
  // Obtener el color del atributo `data-color` y aplicar estilo
  var color = $(option.element).data('color');
  var $option = $('<span></span>').text(option.text).css('color', color);

  return $option;
}
function listaragente() {
  return new Promise((resolve, reject) => {
    if (
      perfil == "Administrador" ||
      perfil == "Gerencia" ||
      perfil == "Calidad"
    ) {
      $.post(
        "../../controller/usuario.php?op=combo_agenteadmin",
        function (data, status) {
          $("#fil_agente").html(
            "<option value='Todo' selected>Todo</option>" + data
          );
          resolve();
        }
      ).fail(function (err) {
        reject(err);
      });
    } else if (perfil == "Operativo" || perfil == "Coordinador") {
      usuid = usu_id;
      $.ajax({
        url: "../../controller/usuario.php?op=combogrupogcom",
        type: "POST",
        data: { usu_id: usuid },
        success: function (datos) {
          var data = JSON.parse(datos);

          if (data && data.length > 0) {
            var resultado = data[0].Resultado;
            if (resultado.trim() !== "") {
              $("#fil_agente").empty();

              var usuarios = resultado.split(", ");
              usuarios.forEach(function (usuario) {
                var partes = usuario.split(":");
                var usuId = partes[0].trim();
                var usuarioNombre = partes[1].trim();

                $("#fil_agente").append(
                  $("<option>", {
                    value: usuId,
                    text: usuarioNombre,
                    selected: false,
                  })
                );
              });
            }
          } else {
            $("#fil_agente").append(
              $("<option>", {
                value: usu_id,
                text: usu_nombre,
                selected: true,
              })
            );
          }
          resolve();
        },
        error: function (err) {
          reject(err);
        },
      });
    } else {
      $.post("../../controller/usuario.php?op=agente", function (data, status) {
        $("#fil_agente").html(data);
        resolve();
      });
    }
  });
}
$("#btnInteresado").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Interesado";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnVolver").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Volver a llamar";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnBuzon").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Buzon de voz";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnIloca").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Ilocalizado";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnSin").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "sin";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnNoInteresado").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "No interesado";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnequivocado").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Numero Equivocado";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnFallecido").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Fallecido";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});
$("#btnFueraServicio").on("click", function (e) {
  e.preventDefault();
  if (campana == "0") {
    swal({
      title: "Sin campaña",
      text: "No puedes ingresar a estados ya que no tienes campañas asignadas.Comunicate con tu jefe inmediato",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  } else if (campana == "" || campana == undefined) {
  } else {
    botonSeleccionado = "Fuera de servicio";
    localStorage.setItem("botonSeleccionado", botonSeleccionado);
    window.location.href = "../listarllamadas/";
  }
});

init();
