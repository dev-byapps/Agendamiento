var tabla;

function init() {
  $("#ciudad_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#ciudad_form")[0]);
  $.ajax({
    url: "../../controller/ciudad.php?op=guardaryeditarciu",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#ciudad_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#ciu_data").DataTable().ajax.reload();
        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#ciudad_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#ciu_data").DataTable().ajax.reload();
        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "0") {
      }
    },
  });
}
$(document).ready(function () {
  listar();
});
function listar() {
  tabla = $("#ciu_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/ciudad.php?op=listarciu",
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
function editar(id, ciu, dep, est) {
  $("#mdltitulo").html("Editar Sucursal");

  $("#ciu_id").val(id);
  $("#ciudad").val(ciu);
  $("#departamento").val(dep);
  $("#est_ciu").val(est);

  //   /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
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
          "../../controller/ciudad.php?op=eliminarciudad",
          { id: id },
          function (data) {}
        );
        $("#ciu_data").DataTable().ajax.reload();
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
$(document).on("click", "#btnnuevo", function () {
  $("#ciu_id").val("");
  $("#ciudad").val("");
  $("#departamento").val("");
  $("#mdltitulo").html("Nueva Ciudad");
  $("#ciudad_form")[0].reset();

  /* TODO:Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});
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
  tabla = $("#ciu_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/ciudad.php?op=listarciuInac",
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
