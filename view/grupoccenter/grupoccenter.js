var tabla;
var originalFilUsuariosOptions = []; // Almacenar las opciones originales

function init() {
    listar();

    $("#grupocc_form").on("submit", function (e) {
        guardaryeditar(e);
      });
}

$(document).ready(function () {
    init();
});

function listar() {
  tabla = $("#grupocc_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/grupocc.php?op=listar",
        type: "post",
        dataType: "json",
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

function integrantes(cc_id, cc_nombre) {
  $("#fil_usuarios").empty(); // Vaciar el select

  tabla = $("#integrantes_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/grupocc.php?op=mostrarintegrantes",
        type: "post",
        dataType: "json",
        data: { cc_id: cc_id },
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

    $("#cc_id_modal").val(cc_id);

  get_singrupocc(cc_id);
  /* TODO: Mostrar Modal */
  $("#mdltitulo2").html("Integrantes " + cc_nombre);
  $("#modalintegrantes").modal("show");
}

function get_singrupocc(cc_id) {
    $.post("../../controller/grupocc.php?op=listarsincc", { cc_id: cc_id }, function(data) {
        $("#fil_usuarios").empty(); // Limpiar opciones previas
        $("#fil_usuarios").html(data); // Agregar nuevas opciones

         // Almacenar las opciones originales
         originalFilUsuariosOptions = $("#fil_usuarios").children('option').clone();

        filterResults(); // Filtrar los resultados inmediatamente después de cargar
    });
}

function filterResults() {
    const searchValue = $("#search").val().toLowerCase(); // Obtener valor de búsqueda

    $("#fil_usuarios").empty(); // Vaciar el select

    // Recorrer las opciones originales y agregar solo las que coinciden
    originalFilUsuariosOptions.each(function() {
        const text = $(this).text().toLowerCase();
        if (text.includes(searchValue)) {
            $("#fil_usuarios").append($(this));
        }
    });

    // Seleccionar la primera opción visible si hay coincidencia
    const firstOption = $("#fil_usuarios").children('option').first();
    if (firstOption.length) {
        firstOption.prop('selected', true);
    } else {
        $("#fil_usuarios").val(''); // Des-seleccionar si no hay coincidencias
    }
}

// Vincular la función de filtrado al campo de búsqueda
$(document).on("input", "#search", function() {
  filterResults();
});

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#grupocc_form")[0]);
    $.ajax({
      url: "../../controller/grupocc.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (datos) {
        if (datos == "1") {
          $("#grupocc_form")[0].reset();
          /* TODO:Ocultar Modal */
          $("#modalmantenimiento").modal("hide");
          $("#grupocc_data").DataTable().ajax.reload();
  
          /* TODO:Mensaje de Confirmacion */
          swal({
            title: "BYAPPS::CRM",
            text: "Registrado Correctamente.",
            type: "success",
            confirmButtonClass: "btn-success",
          });
        } else if (datos == "2") {
          $("#grupocc_form")[0].reset();
          /* TODO:Ocultar Modal */
          $("#modalmantenimiento").modal("hide");
          $("#grupocc_data").DataTable().ajax.reload();
  
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
function editar(cc_id, cc_nom, cc_com, cc_est) {
    $("#mdltitulo").html("Editar Grupo Llamadas");
  
    $("#cc_id").val(cc_id);
    $("#cc_nombre").val(cc_nom);
    $("#cc_comentario").val(cc_com);
    $("#cc_estado").val(cc_est);
  
    /* TODO: Mostrar Modal */
    $("#modalmantenimiento").modal("show");
}
function eliminar(cc_id) {
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
            "../../controller/grupocc.php?op=eliminar",
            { cc_id: cc_id },
            function (data) {}
          );
  
          $("#grupocc_data").DataTable().ajax.reload();
  
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
    $("#cc_id").val("");
    $("#mdltitulo").html("Nuevo Grupo Llamadas");
    $("#grupocc_form")[0].reset();
  
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
    tabla = $("#grupocc_data")
      .dataTable({
        aProcessing: true,
        aServerSide: true,
        searching: true,
        lengthChange: false,
        colReorder: true,
        ajax: {
          url: "../../controller/grupocc.php?op=listarInactivos",
          type: "post",
          dataType: "json",
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
function integrantes(cc_id, cc_nombre) {
    tabla = $("#integrantes_data")
      .dataTable({
        aProcessing: true,
        aServerSide: true,
        searching: true,
        lengthChange: false,
        colReorder: true,
        ajax: {
          url: "../../controller/grupocc.php?op=mostrarintegrantes",
          type: "post",
          dataType: "json",
          data: { cc_id: cc_id },
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
  
      $("#cc_id_modal").val(cc_id);
  
    get_singrupocc(cc_id);
    /* TODO: Mostrar Modal */
    $("#mdltitulo2").html("Integrantes " + cc_nombre);
    $("#modalintegrantes").modal("show");
}
  function eliminarintegrante(usucc_id, cc_id) {
    swal(
      {
        title: "BYAPPS::CRM",
        text: "Esta seguro de Eliminar el integrante?",
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
            "../../controller/grupocc.php?op=eliminarintegrante",
            { usucc_id: usucc_id },
            function (data) {}
          );
  
          $("#integrantes_data").DataTable().ajax.reload();
          get_singrupocc(cc_id);
  
          swal({
            title: "BYAPPS::CRM",
            text: "Integrante Eliminado.",
            type: "success",
            confirmButtonClass: "btn-success",
          });
        }
      }
    );
}
$(document).on("click", "#btnagregar", function (cc_id) {
    var usu_id = $("#fil_usuarios").val();
    var cc_id = $("#cc_id_modal").val();
  
    $.post(
      "../../controller/grupocc.php?op=agregarintegrante",
      { usu_id: usu_id, cc_id: cc_id },
      function (data) {}
    );
  
    $("#integrantes_data").DataTable().ajax.reload();
    get_singrupocc(cc_id);
    $("#search").val('');
  
    swal({
      title: "BYAPPS::CRM",
      text: "Registrado Correctamente.",
      type: "success",
      confirmButtonClass: "btn-success",
    });
});

