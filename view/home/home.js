var selectedValue1 = "Individual";
var categoriatarea = "";

function init() {
  localStorage.clear();
}
function valcom() {
  $.post(
    "../../controller/comunicados.php?op=vencido",
    function (data, status) {}
  );
}
$(document).ready(function () {
  if (usu_perfil != "RRHH") {
    num_tareas();
    listartareas();
    
    buscarusuario()
      .then(() => comunicadosInternos())
      .then(() => indiVentas())
      .then(() => indiGestion())
      .catch((error) => {
        console.error("Error executing functions:", error);
      });

      campañasAct();
      agenda();
      ingresoConsola();
      
      
  } else {
    num_tareas();
    listartareas();
    buscarusuario()
      .then(() => comunicadosInternos())
      .catch((error) => {
        console.error("Error executing functions:", error);
      });      
  }
});

// PERFIL
function buscarusuario() {
  return new Promise((resolve, reject) => {
    $.post(
      "../../controller/usuario.php?op=buscarusuario",
      { usu_id: usu_id },
      function (data, status) {
        var nombre = "";
        var parsedData = JSON.parse(data);

        if (
          parsedData.length > 0 &&
          parsedData[0]["nombre_completo"] !== undefined
        ) {
          nombre = parsedData[0]["nombre_completo"];
        }

        var saludo = "Hola, " + nombre;
        $("#nom").text(saludo);
        resolve();
      }
    );
  });
}

// COMUNICADOS INTERNOS
function comunicadosInternos() {
  valcom();
  return new Promise((resolve, reject) => {
    let promises = [];

    promises.push(
      new Promise((resolve, reject) => {
        $.post(
          "../../controller/comunicados.php?op=numero_comeninternos",
          function (data, status) {
            var parsedData = JSON.parse(data);
            var countComId = parsedData[0]["COUNT(comi_id)"];
            $("#conteo_comuni").text(countComId);
            resolve();
          }
        ).fail(reject);
      })
    );

    promises.push(
      new Promise((resolve, reject) => {
        $.post(
          "../../controller/comunicados.php?op=comunicadosInternos",
          function (data, status) {
            data = JSON.parse(data);
            $("#com_internos").html(data);
            resolve();
          }
        ).fail(reject);
      })
    );

    Promise.all(promises).then(resolve).catch(reject);
  });
}
function btcomunicado(event, id_com) {
  event.preventDefault();
  $("#mdltitulo").html("Comunicado");

  $.post(
    "../../controller/comunicados.php?op=detallecomunicadosInternos",
    { id_com: id_com },
    function (data, status) {
      data = JSON.parse(data);
      var ruta = "../../documents/comunicados/" + data[0]["comi_rut"];
      $("#imgcomuni").prop("src", ruta);
      $("#asunto").text(data[0]["comi_asun"]);
      $("#contenido").html(data[0]["comi_det"]);
    }
  );

  /* TODO:Mostrar Modal */
  $("#modalcomunicados").modal("show");
}

// INDICADORES VENTAS
$("#dato1 .dropdown-item").on("click", function (e) {
  e.preventDefault();
  selectedValue1 = $(this).data("value");
  $("#selected-option").text(selectedValue1);
  indiVentas();
  indiGestion();
});
function indiVentas() {
  return new Promise((resolve, reject) => {
    $.post(
      "../../controller/cliente.php?op=sumadesebolsados",
      { dato: selectedValue1 },
      function (data, status) {
        data = JSON.parse(data);
        if (data[0]["suma"] == null || data[0]["suma"] == "") {
          var val = "$ 0";
        } else {
          var sumades = data[0]["suma"];
          var val =
            "$ " +
            parseFloat(sumades).toLocaleString("es-ES", {
              maximumFractionDigits: 0,
            });
        }

        $("#sumades").html(val);
        // Luego de completar la primera operación, procedemos a la segunda

        $("#ventas_data").DataTable({
          processing: false,
          serverSide: false,
          searching: false,
          lengthChange: false,
          colReorder: false,
          ordering: false,
          ajax: {
            url: "../../controller/usuario.php?op=indicadoresventa",
            type: "POST",
            dataType: "json",
            data: {
              usu_id: usu_id,
              usu_perfil: usu_perfil,
              dato: selectedValue1,
            },
            dataSrc: "",
          },
          destroy: true,
          responsive: true,
          info: false,
          paging: false,
          autoWidth: false,
          language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "Ningún dato disponible en esta tabla",
            infoThousands: ",",
            loadingRecords: "Cargando...",
          },
          columns: [
            {
              data: "comentario",
              render: function (data, type, row) {
                var entidad = row.ent_nom;
                var data = data;
                return (
                  '<button type="button" class="btn  btn-secondary-outline btn-sm" onclick="mostrarComentario(\'' +
                  encodeURIComponent(data) +
                  "', '" +
                  encodeURIComponent(entidad) +
                  '\')"><i class="fa fa-check"></i></button>'
                );
              },
            },
            { data: "ent_nom" },
            {
              data: "suma_operaciones",
              render: function (data, type, row) {
                if (type === "display" || type === "filter") {
                  return (
                    '<span style="font-weight: 800;">$ ' +
                    parseFloat(data).toLocaleString("es-ES", {
                      maximumFractionDigits: 0,
                    }) +
                    "</span>"
                  );
                }
                return data;
              },
            },
            {
              data: null,
              render: function (data, type, row) {
                var suma_operaciones = parseInt(row.suma_operaciones) || 0;
                // Calcular el progreso
                var progress =
                  sumades !== 0 ? (suma_operaciones / sumades) * 100 : 0;
                // Asegurarse de que progress no sea NaN
                progress = isNaN(progress) ? 0 : progress;
                // Limitar el valor máximo a 100
                progress = Math.min(progress, 100);
                var progress_html =
                  '<div class="progress-with-amount">' +
                  '<progress class="progress progress-success progress-no-margin" value="' +
                  progress +
                  '" max="100">' +
                  Math.round(progress) +
                  "%</progress>" +
                  '<div class="progress-with-amount-number">' +
                  Math.round(progress) +
                  "%</div>" +
                  "</div>";
                return progress_html;
              },
            },
          ],
          dom: '<"table-responsive"t>',
          initComplete: function (settings, json) {
            // Ocultar el thead después de inicializar la tabla
            $("#ventas_data thead").hide();
            resolve();
          },
        });
      }
    ).fail(reject);
  });
}
function mostrarComentario(comentario, entidad) {
  comentario = decodeURIComponent(comentario);
  entidad = decodeURIComponent(entidad);

  swal({
    title: entidad,
    text: comentario,
    confirmButtonClass: "btn btn-primary swal-btn-text",
  });
}

// INDICADORES DE GESTION
function indiGestion() {
  $.post(
    "../../controller/usuario.php?op=indicadores_gestion",
    {
      usu_id: usu_id,
      usu_perfil: usu_perfil,
      usu_grupocom: usu_grupocom,
      dato: selectedValue1,
    },
    function (data, status) {
      data = JSON.parse(data);
      $("#interesado").html(data.interesado);
      $("#radicado").html(data.radicado);
      $("#suma").html(data.sumaradicadas);
      $("#gestiones").html(data.gestiones);
      $("#fecrea").html(data.fecrea);
      $("#feradicado").html(data.feradicado);
      $("#feconsola").html(data.feconsola);
    }
  );
}

//CONTAC CENTER
function campañasAct() {
  $.post(
    "../../controller/campana.php?op=contcampact",
    function (data, status) {
      var response = JSON.parse(data);
      if (response.length > 0) {
        var cantidadCampanas = response[0].cantidad_campanas;

        $("#campact").html(cantidadCampanas);
      } else {
        $("#campact").html(0);
      }
    }
  );
}
function agenda() {
  $.post("../../controller/campana.php?op=agenda", function (data, status) {
    var response = JSON.parse(data);
    if (response.length > 0) {
      var agendacount = response[0].numagenda;

      $("#numagenda").html(agendacount);
    } else {
      $("#numagenda").html(0);
    }
  });
}
function ingresoConsola() {
  $.post(
    "../../controller/llamada.php?op=ingresoConsola",
    function (data, status) {
      var response = JSON.parse(data);

      if (response.length > 0 && response[0].reco_fech) {
        var fechaOriginal = response[0].reco_fech;
        // Convierte la fecha a un objeto Date
        var fechaObj = new Date(fechaOriginal);
        // Formatea la fecha
        var options = {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
          hour: "2-digit",
          minute: "2-digit",
          hour12: true,
        };
        // Convertimos a formato d/m/y h:m am/pm
        var fechaFormateada = fechaObj
          .toLocaleString("en-GB", options)
          .replace(",", "");

        $("#feconsola").html(fechaFormateada);
      } else {
        $("#feconsola").html("");
      }
    }
  );
}

// TAREAS
function num_tareas() {
  return new Promise((resolve, reject) => {
    $.post(
      "../../controller/tareas.php?op=numtareas",
      { usu_id: usu_id },
      function (data, status) {
        data = JSON.parse(data);
        $("#num_tareas").html(data[0]["count(tar_id)"]);
        resolve();
      }
    );
  });
}
function listartareas() {
  return new Promise((resolve, reject) => {
    $("#tareas_data").DataTable({
      aProcessing: true,
      aServerSide: true,
      searching: false,
      lengthChange: false,
      colReorder: true,
      ordering: false,
      ajax: {
        url: "../../controller/tareas.php?op=listar",
        type: "post",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
          reject(e); // Rechaza la promesa si hay un error
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 4,
      autoWidth: false,
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
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
        resolve(); // Resuelve la promesa cuando la tabla se haya inicializado
      },
    });
  });
}
function editar_tarea(
  id,
  asun,
  det,
  comen,
  idasigpor,
  asigpor,
  idasiga,
  asiga,
  idcli,
  cli,
  clas,
  pri,
  feve,
  usu,
  est,
  e
) {
  e.preventDefault();
  $("#comentario").show();
  categoriatarea = clas;
  listarcat()
    .then(() => {
      $("#protected-content-container").show();
      $("#protected-summernote").show();
      $("#divcreado").show();
      $("#tar_com").summernote("code", "");

      if (usu == idasigpor) {
        $("#tar_asun").prop("disabled", false);
        $("#tar_det").prop("disabled", false);
        $("#tar_asig").prop("disabled", false);
        $("#tar_cli").prop("disabled", false);
      } else {
        $("#tar_asun").prop("disabled", true);
        $("#tar_det").prop("disabled", true);
        $("#tar_asig").prop("disabled", true);
        $("#tar_cli").prop("disabled", true);
      }

      $("#mdltitulo2").html("Editar Tarea");
      $("#tar_id").val(id);
      $("#tar_asun").val(asun);
      $("#tar_det").val(det);
      $("#creado").html(asigpor);

      //asignado a
      $("#tar_asig").html(
        '<option value="' + idasiga + '">' + asiga + "</option>"
      );
      $("#tar_asig").val(idasiga).trigger("change");

      //cliente
      $("#tar_cli").html('<option value="' + idcli + '">' + cli + "</option>");
      $("#tar_cli").val(idcli).trigger("change");

      $("#tar_cat").val(clas);
      $("#tar_pri").val(pri);
      $("#tar_fcierre").val(feve);

      //estado
      var estadoSelect = $("#tar_est");
      if(est == 1){
        estadoSelect.html(`
          <option value="1" ${est === "1" ? "selected" : ""}>NUEVA</option>
          <option value="2" ${est === "2" ? "selected" : ""}>EN CURSO</option>
          <option value="3" ${est === "3" ? "selected" : ""}>COMPLETADA</option>
        `);
      }else if(est == 4){
        estadoSelect.html(`
          <option value="2" ${est === "2" ? "selected" : ""}>EN CURSO</option>
          <option value="3" ${est === "3" ? "selected" : ""}>COMPLETADA</option>
          <option value="4" ${est === "4" ? "selected" : ""}>VENCIDA</option>
        `);
      }else{
        estadoSelect.html(`
          <option value="2" ${est === "2" ? "selected" : ""}>EN CURSO</option>
          <option value="3" ${est === "3" ? "selected" : ""}>COMPLETADA</option>
        `);
      }
      

      // Destruye la instancia previa de Summernote (si existe)
      if ($("#protected-summernote").data("summernote")) {
        $("#protected-summernote").summernote("destroy");
      }

      // Inicializar Summernote para #protected-summernote
      $("#protected-summernote")
        .on("summernote.init", function () {
          $(this).next(".note-editor").find(".note-resizebar").hide(); // Ocultar barra de redimensionamiento solo para este editor
        })
        .summernote({
          toolbar: false,
          placeholder: "Este contenido es solo de lectura.",
          callbacks: {
            onInit: function () {
              var contentHeight = $("#protected-summernote").summernote(
                "scrollHeight"
              );
              $("#protected-summernote").summernote("height", contentHeight);
            },
          },
        });

      $("#protected-summernote").summernote("code", comen);

      // Ajustar la altura después de establecer el contenido
      setTimeout(function () {
        var contentHeight = $("#protected-summernote").summernote(
          "scrollHeight"
        );
        $("#protected-summernote").summernote("height", contentHeight);
      }, 0); // Usar timeout para asegurar que el contenido esté renderizado

      // Hacer el editor solo lectura
      $("#protected-summernote").summernote("disable");

      $(".note-editable").css({
        "line-height": "1.2", // Ajusta la altura de línea según sea necesario
        margin: "0", // Elimina márgenes adicionales
        padding: "0", // Elimina relleno adicional
      });

      // Específicamente para párrafos
      $(".note-editable p").css({
        "margin-top": "0", // Elimina el margen superior
        "margin-bottom": "0.2em", // Ajusta el margen inferior según sea necesario
      });

      // Mostrar Modal
      $("#modaltarea").modal("show");
    })
    .catch((error) => {
      swal("Error al listar categorías:", error);
    });
}
function listarcat() {
  return new Promise((resolve, reject) => {
    $.post("../../controller/tareas.php?op=combocat", function (data, status) {
      $("#tar_cat").html(data);

      // Si categoriatarea no es vacío o null, establece el valor
      if (categoriatarea) {
        $("#tar_cat").val(categoriatarea);
      }

      resolve(); // Resuelve la promesa cuando la operación es exitosa
    }).fail(function (jqXHR, textStatus, errorThrown) {
      reject(errorThrown); // Rechaza la promesa en caso de error
    });
  });
}
function limpiarmodaltarea() {
  $("#tar_id").val("");
  $("#tar_asun").val("");
  $("#tar_det").val("");
  $("#protected-summernote").summernote("code", "");
  $("#protected-summernote").hide();
  $("#tar_com").summernote("code", "");
  $("#creado").html("");
  $("#tar_asig").val("").trigger("change");
  $("#tar_cli").val("").trigger("change");
  $("#tar_cat").val(1);
  $("#tar_pri").val(1);
  var currentDate = moment().format("DD/MM/YYYY");
  $("#tar_fcierre").val(currentDate);
  $("#tar_est").val(1);
  $("#tar_asun").prop("disabled", false);
  $("#tar_det").prop("disabled", false);
  $("#tar_asig").prop("disabled", false);
  $("#tar_cli").prop("disabled", false);

  $("#protected-content-container").hide();
}
$(document).on("click", "#crear_tareas", function (e) {
  e.preventDefault();
  $("#comentario").hide();  
  categoriatarea = "";
  limpiarmodaltarea();
  listarcat().then(() => {
    $("#mdltitulo2").html("Crear Tarea");
    $("#tar_id").val("");

    //estado
    var estadoSelect = $("#tar_est");
    estadoSelect.html(`
      <option value="1" selected>NUEVA</option>
      <option value="2">EN CURSO</option>
    `);

    $("#divcreado").hide();
    asignadoa();
    cliente();

    /* TODO:Mostrar Modal */
    $("#modaltarea").modal("show");
  });
});
function asignadoa() {
  $.post("../../controller/tareas.php?op=usu", function (data) {
    var data = JSON.parse(data);
    usuPerfil = data.perfil;
    if (usuPerfil == "Asesor") {
      $.post("../../controller/tareas.php?op=usu", function (data) {
        var data = JSON.parse(data);

        $("#tar_asig").html(
          '<option value="' + data.id + '">' + data.nom + "</option>"
        );
        $("#tar_asig").val(data.id).trigger("change");
        $("#tar_asig").prop("disabled", true);
      });
    } else {
      $("#tar_asig").select2({
        placeholder: "Asigna a un Usuario",
        allowClear: true,
        ajax: {
          url: "../../controller/tareas.php?op=adminselect",
          type: "POST",
          dataType: "json",
          delay: 250,
          data: function (params) {
            return {
              term: params.term.trim().toLowerCase(),
              usuPerfil: usuPerfil,
            };
          },
          processResults: function (data) {
            console.log(data);
            return {
              results: data.map(function (item) {
                return {
                  id: item.usu_id,
                  text: item.detu_nom + " " + item.detu_ape,
                };
              }),
            };
          },
          cache: true,
        },
        minimumInputLength: 2,
      });
    }
  });
}
function cliente() {
  $("#tar_cli").select2({
    placeholder: "Relaciona un cliente",
    allowClear: true,
    ajax: {
      url: "../../controller/cliente.php?op=selectcli",
      type: "POST",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          term: params.term.trim().toLowerCase(),
        };
      },
      processResults: function (data) {

        return {
          results: data.map(function (item) {
            return {
              id: item.cli_id,
              text: item.cli_nom,
            };
          }),
        };
      },
      cache: true,
    },
    minimumInputLength: 2,
  });
}
$("#tarea_form").on("submit", function (e) {
  e.preventDefault();
  nuevaoeditartarea();
});
function nuevaoeditartarea() {
  var formData = new FormData($("#tarea_form")[0]);
  if ($("#tar_cli").val() == "" || $("#tar_cli").val() == null) {
    formData.append("tar_cli", 0);
  }
  if ($("#tar_asig").val() == "" || $("#tar_asig").val() == null) {
    formData.append("tar_asig", 0);
  }

  $.ajax({
    url: "../../controller/tareas.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#tarea_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaltarea").modal("hide");
        $("#tareas_data").DataTable().ajax.reload();
        $("#tarea_form")[0].reset();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#tarea_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaltarea").modal("hide");
        $("#tareas_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else {
        swal("Error con el registro : " + datos + ".");
      }
    },
  });
}

init();