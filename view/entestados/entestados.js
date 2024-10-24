var tabla;

function init() {
  $("#estadoent_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#estadoent_form")[0]);
  $.ajax({
    url: "../../controller/estadosent.php?op=guardaryeditarestado",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#estadoent_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#estadoent_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#estadoent_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#estadoent_data").DataTable().ajax.reload();
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
  var ent_id = $("#ent_id").val();
  tabla = $("#estadoent_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/estadosent.php?op=listarestados",
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
function editar(est_id, estado, crm, ent) {
  $("#mdltitulo").html("Editar Estado");

  /* TODO: Mostrar Informacion en los inputs */
  $("#est_id").val(est_id);
  $("#ent_id").val(ent);
  $("#est_ent").val(estado);
  $("#est_crm").val(crm);

  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}
function eliminarestado(est_id) {
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
          "../../controller/estadosent.php?op=eliminarestado",
          { est_id: est_id },
          function (data) {}
        );
        $("#estadoent_data").DataTable().ajax.reload();
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
  $("#est_id").val("");
  $("#mdltitulo").html("Nuevo Estado");
  $("#estadoent_form")[0].reset();

  /* TODO:Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

function inactivos() {
  var ent_id = $("#ent_id").val();
  tabla = $("#estadoent_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/estadosent.php?op=listarInactivos",
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
function activar(estent_id) {
  $.ajax({
    url: "../../controller/estadosent.php?op=activar",
    type: "POST",
    data: { estent_id: estent_id },
    success: function (datos) {
      inactivos();

      /* TODO:Mensaje de Confirmacion */
      swal({
        title: "BYAPPS::CRM",
        text: "Registro Modificado.",
        type: "success",
        confirmButtonClass: "btn-success",
      });
    },
  });
}

init();
