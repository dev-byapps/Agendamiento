var pageLoaded = false;
var usuPerfil;
var filtro = false;

$(document).ready(function () {
  listarDatos().then(() => {
    pageLoaded = true;
  });

  $("#daterange, #fil_cattarea, #fil_catestado").on("change", function () {
    if (!pageLoaded) {
      return;
    }
    listar();
  });
});
function listarDatos() {
  return $.post("../../controller/tareas.php?op=combocat")
    .done(function (data) {
      var campotodo = '<option value="0">TODO</option>' + data;
      $("#fil_cattarea").html(campotodo);
      $("#tar_cat").html(data);
      $("#btntodo").prop("disabled", false);
      listar();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      alert("Error al cargar datos:", textStatus, errorThrown);
    });
}
//solo lista nueva, en curso y vencida
function listar() {
  if ($.fn.DataTable.isDataTable("#tarea_data")) {
    $("#tarea_data").DataTable().destroy();
  }
  var url = "../../controller/tareas.php?op=listartareas";

  if(filtro == false){
    url = "../../controller/tareas.php?op=listartareasinicio";
  }
  $("#tarea_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ordering: false,
      ajax: {
        url: url,
        type: "post",
        dataType: "json",
        data: function (d) {
          filtro = true;
          // Añadir los datos del formulario al objeto 'd'
          var formData = new FormData($("#filtros_form")[0]);
          formData.append('filtro', filtro);
          formData.forEach(function (value, key) {
            d[key] = value;
          });
          return d;
        },
        error: function (e) {
          alert(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      autoWidth: false,
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
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
            ": Activar para ordenar la columna de manera descendente",
        },
      },
    })
    .DataTable();
}
$(document).on("click", "#btntodo", function (event) {
  event.preventDefault();
  // Inicializar el campo de entrada con el rango de fechas
  $("#daterange").daterangepicker({
    locale: {
      format: "DD/MM/YYYY",
      applyLabel: "Aplicar",
      cancelLabel: "Cancelar",
      customRangeLabel: "Personalizado",
      daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
    },
    startDate: moment().startOf("month"),
    endDate: moment(),
    autoApply: true,
    ranges: {
      Hoy: [moment(), moment()],
      Ayer: [moment().subtract(1, "days"), moment().subtract(1, "days")],
      "Últimos 7 Días": [moment().subtract(6, "days"), moment()],
      "Últimos 30 Días": [moment().subtract(29, "days"), moment()],
      "Este Mes": [moment().startOf("month"), moment().endOf("month")],
      "Mes Anterior": [
        moment().subtract(1, "month").startOf("month"),
        moment().subtract(1, "month").endOf("month"),
      ],
    },
    alwaysShowCalendars: true,
  });
  $("#fil_cattarea").val("0").trigger('change');
  $('#fil_catestado').val('0').trigger('change');
  filtro = false;
  listar();
});
$(document).on("click", "#btnnueva", function () {
  $("#mdltitulo").html("Nueva Tarea");
  limpiar();
  asignadoa();
  cliente();
  $("#descrip").hide();

  //estado
  var estadoSelect = $("#tar_est");
  estadoSelect.html(`
      <option value="1" selected>NUEVA</option>
      <option value="2">EN CURSO</option>
    `);

  // Configura el editor para la nueva tarea
  $("#tar_com").summernote({
    popover: false,
    height: 200,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    callbacks: {
      onInit: function () {
        // Mostrar la barra de redimensionamiento al inicializar
        $(this).next(".note-editor").find(".note-resizebar").show();
      },
    },
  });

  $("#divcreado").hide();

  /* TODO:Mostrar Modal */
  $("#modaltarea").modal("show");
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
function editar(
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
  est
) {

  $("#descrip").show();
  $("#protected-content-container").show();
  $("#protected-summernote").show();
  $("#divcreado").show();
  $("#tar_com").summernote("code", "");

  if (usu == idasigpor) {
    $("#tar_asun").prop("disabled", false);
    $("#tar_det").prop("disabled", false);
    $("#tar_asig").prop("disabled", false);
    $("#tar_cli").prop("disabled", false);
    asignadoa();
    cliente();
  } else {
    $("#tar_asun").prop("disabled", true);
    $("#tar_det").prop("disabled", true);
    $("#tar_asig").prop("disabled", true);
    $("#tar_cli").prop("disabled", true);
  }

  $("#mdltitulo").html("Editar Tarea");
  $("#tar_id").val(id);
  $("#tar_asun").val(asun);
  $("#tar_det").val(det);
  $("#creado").html(asigpor);

  //asignado a
  $("#tar_asig").html('<option value="' + idasiga + '">' + asiga + "</option>");
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
}else if(est == 5){
  estadoSelect.html(`
    <option value="2" ${est === "2" ? "selected" : ""}>EN CURSO</option>
    <option value="3" ${est === "3" ? "selected" : ""}>COMPLETADA</option>
    <option value="5" ${est === "5" ? "selected" : ""}>ELIMINADA</option>
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
    var contentHeight = $("#protected-summernote").summernote("scrollHeight");
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

  // Configura el editor para la nueva tarea
  $("#tar_com").summernote({
    popover: false,
    height: 600,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    callbacks: {
      onInit: function () {
        var $editable = $(this).next('.note-editor').find('.note-editable');
      }
    },
  });

  /* TODO:Mostrar Modal */
  $("#modaltarea").modal("show");
}
function eliminar(id) {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "Esta seguro de Eliminar el registro?",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        $.post(
          "../../controller/tareas.php?op=eliminar",
          { id: id },
          function (data) {}
        );
        $("#tarea_data").DataTable().ajax.reload();
        swal({
          title: "BYAPPS::CRM",
          text: "Registro Eliminado.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    }
  );
}
function limpiar() {
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
$("#tarea_form").on("submit", function (e) {
  guardaryeditar(e);
});
function guardaryeditar(e) {
  e.preventDefault();
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
        $("#tarea_data").DataTable().ajax.reload();

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
        $("#tarea_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else {
        alert("Error con el registro : " + datos + ".");
      }
    },
  });
}
function getDateRange() {
  var now = new Date();
  var startDate = new Date(now.getFullYear(), now.getMonth(), 1); // Primer día del mes
  var endDate = now; // Fecha actual

  // Formatear las fechas como dd/mm/yyyy
  var formatDate = function (date) {
    var day = String(date.getDate()).padStart(2, "0");
    var month = String(date.getMonth() + 1).padStart(2, "0"); // Mes comienza en 0
    var year = date.getFullYear();
    return `${day}/${month}/${year}`;
  };

  return {
    start: formatDate(startDate),
    end: formatDate(endDate),
  };
}
