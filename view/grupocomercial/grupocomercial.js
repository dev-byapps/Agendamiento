var tabla;
var originalFilUsuariosOptions = [];

function init() {
  $("#grupocom_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}
$(document).ready(function () {
  listar();

});
function listar() {
  tabla = $("#grupocom_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/grupocom.php?op=listar",
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
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#grupocom_form")[0]);
  $.ajax({
    url: "../../controller/grupocom.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#grupocom_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#grupocom_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#grupocom_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#grupocom_data").DataTable().ajax.reload();

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
function editar(com_id) {
  $("#mdltitulo").html("Editar Grupo Comercial");

  /* TODO: Mostrar Informacion en los inputs */
  $.post(
    "../../controller/grupocom.php?op=mostrar",
    { com_id: com_id },
    function (data) {
      data = JSON.parse(data);
      $("#com_id").val(data.com_id);
      $("#com_nombre").val(data.com_nombre);
      $("#com_comentario").val(data.com_comentario);
      $("#com_estado").val(data.com_estado);
    }
  );

  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}
function eliminar(com_id) {
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
          "../../controller/grupocom.php?op=eliminar",
          { com_id: com_id },
          function (data) {}
        );

        $("#grupocom_data").DataTable().ajax.reload();

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

function get_singrupocom() {
  $.post("../../controller/grupocom.php?op=listarsincom", function (data) {
    $("#fil_usuarios").empty().append(data);
    
    // Almacenar las opciones originales
    originalFilUsuariosOptions = $("#fil_usuarios").children('option').clone();
    
    filterResults(); // Aplicar filtro inmediatamente después de cargar
  });
}

function filterResults() {
  const searchValue = $("#searchgcom").val().toLowerCase(); // Obtener valor de búsqueda

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

$(document).on("input", "#searchgcom", function() {
  filterResults();
});

function integrantes(com_id, com_nombre) {
  tabla = $("#integrantes_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/grupocom.php?op=mostrarintegrantes",
        type: "post",
        dataType: "json",
        data: { com_id: com_id },
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

  get_singrupocom();
  /* TODO: Mostrar Modal */
  $("#mdltitulo2").html("Integrantes " + com_nombre);
  $("#com_id_modal").val(com_id);
  $("#modalintegrantes").modal("show");
}
function eliminarintegrante(usu_id) {
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
          "../../controller/grupocom.php?op=eliminarintegrante",
          { usu_id: usu_id },
          function (data) {}
        );

        $("#integrantes_data").DataTable().ajax.reload();
        get_singrupocom();

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

$(document).on("click", "#btnagregar", function (com_id) {
  var usu_id = $("#fil_usuarios").val();
  var com_id = $("#com_id_modal").val();

  $.post(
    "../../controller/grupocom.php?op=agregarintegrante",
    { com_id: com_id, usu_id: usu_id },
    function (data) {}
  );

  $("#integrantes_data").DataTable().ajax.reload();
  get_singrupocom();
  $("#searchgcom").val('');

  swal({
    title: "BYAPPS::CRM",
    text: "Registrado Correctamente.",
    type: "success",
    confirmButtonClass: "btn-success",
  });
});
$(document).on("click", "#btnnuevo", function () {
  $("#com_id").val("");
  $("#mdltitulo").html("Nuevo Grupo Comercial");
  $("#grupocom_form")[0].reset();

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
  tabla = $("#grupocom_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/grupocom.php?op=listarInactivos",
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

init();
