var ent_id = $("#ent_id").val();
var tabla;

function init() {
  $("#convenio_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}
$(document).ready(function () {
  listar();
});
function listar() {
  tabla = $("#convent_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/convenio.php?op=buscarconvenios",
        type: "post",
        dataType: "json",
        data: {
          ent_id: ent_id,
        },
        error: function (e) {
          console.log(e.responseText);
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
$(document).on("click", "#btnnuevo", function () {
  $("#con_id").val("");
  $("#nom_conv").val("");
  $("#mdltitulo").html("Nuevo Convenio");
  $("#convenio_form")[0].reset();
  /* TODO:Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#convenio_form")[0]);
  $.ajax({
    url: "../../controller/convenio.php?op=guardaryeditarcon",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#convenio_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#convent_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#convenio_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#convent_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else {
        swal({
          title: "BYAPPS::CRM",
          text: "Error en el registro.",
          type: "danger",
          confirmButtonClass: "btn-danger",
        });
      }
    },
  });
}
function editar(idconv, nomconv, estconv) {
  $("#mdltitulo").html("Editar Estado");

  /* TODO: Mostrar Informacion en los inputs */
  $("#con_id").val(idconv);
  $("#nom_conv").val(nomconv);
  $("#con_est").val(estconv);

  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}
function eliminarestado(idconv) {
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
          "../../controller/convenio.php?op=eliminarconvenio",
          { idconv: idconv },
          function (data) {}
        );

        $("#convent_data").DataTable().ajax.reload();

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
$(document).on("click", "#papelera", function () {
  var $button = $(this);
  var $icon = $button.find("i");

  if ($icon.hasClass("fa-trash")) {
    // Cambiar el icono a check y el texto a Activos
    $icon.removeClass("fa-trash").addClass("fa-check");
    $button.removeClass("btn-danger").addClass("btn-success");
    $button.html('<i class="fa fa-check"></i>&nbsp;Activos');
    inactivos();
  } else {
    // Cambiar el icono a papelera y el texto a Papelera
    $icon.removeClass("fa-check").addClass("fa-trash");
    $button.removeClass("btn-success").addClass("btn-danger");
    $button.html('<i class="fa fa-trash"></i>&nbsp;Papelera');
    listar();
  }
});
function inactivos() {
  tabla = $("#convent_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/convenio.php?op=buscarconveniosInactivos",
        type: "post",
        dataType: "json",
        data: {
          ent_id: ent_id,
        },
        error: function (e) {
          console.log(e.responseText);
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
init();
