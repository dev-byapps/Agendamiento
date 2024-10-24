function init() {
  listarcomunicados();
}
function listarcomunicados() {
  $("#comunicados_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ordering: false,
    ajax: {
      url: "../../controller/comunicados.php?op=buscarcomunicadosInternos",
      type: "post",
      dataType: "json",
      data: {
        perfil: usuPerfil,
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
  });
}
function datos(ruta, asun, det) {
  var asunto = decodeURIComponent(asun).replace(/\+/g, " ");

  $("#mdltitulo").html("Comunicado");
  $("#imgcomuni").prop("src", ruta);
  $("#asunto").text(det);
  $("#contenido").html(asunto);

  $("#modalvisual").modal("show");
}
function editar(id, det, asun, clas, fefin, est) {
  $("#img_sel").css("display", "none");
  var detalle = decodeURIComponent(det).replace(/\+/g, " ");
  $("#mdltitulo").html("Editar Comunicado");
  $("#com_id").val(id);
  $("#com_asunto").val(asun);
  $("#com_clas").val(clas);
  $("#com_fcierre").val(fefin);
  $("#com_estado").val(est);
  $("#com_coment").summernote("code", detalle);

  $("#modalcomunicado").modal("show");
}
$(document).on("click", "#btnnuevo", function () {
  $("#mdltitulo").html("Nuevo Comunicado");
  $("#img_sel").css("display", "block");
  $("#com_id").val("");
  $("#com_asunto").val("");
  $("#com_coment").summernote("code", "");
  $("#modalcomunicado").modal("show");
});
$("#com_form").on("submit", function (e) {
  guardaryeditar(e);
});
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#com_form")[0]);
  formData.append("usu_id", usu_id);
  // Verificar si se ha seleccionado un documento si estamos en nuevo doc
  if ($("#mdltitulo").html() == "Nuevo Comunicado") {
    if ($("#fileTest")[0].files.length === 0) {
      swal("Por favor, seleccione una imagen antes de guardar.");
      return;
    }
  }
  $.ajax({
    url: "../../controller/comunicados.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#com_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalcomunicado").modal("hide");
        $("#comunicados_data").DataTable().ajax.reload();

        swal({
          title: "BYAPPS::CRM",
          text: "Comunicado Guardado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#com_form")[0].reset();
        //   /* TODO:Ocultar Modal */
        $("#modalcomunicado").modal("hide");
        $("#comunicados_data").DataTable().ajax.reload();

        swal({
          title: "BYAPPS::CRM",
          text: "Comunicado Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    },
  });
}
function eliminar(comid) {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "Esta seguro de Eliminar el comunicado?",
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
          "../../controller/comunicados.php?op=cambiarestadoeliminado",
          { comid: comid },
          function (data) {
            console.log(data);
          }
        );

        $("#comunicados_data").DataTable().ajax.reload();

        swal({
          title: "BYAPPS::CRM",
          text: "Documento Eliminado.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    }
  );
}
//*************CONFIGURACIONES*/
$("#com_coment").summernote({
  popover: false,
  height: 150,
  lang: "es-ES",

  toolbar: [
    ["style", ["bold", "italic", "underline", "clear"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["height", ["height"]],
  ],
});
$("#fileTest").on("change", function () {
  var fileInput = $(this);
  var files = fileInput[0].files;
  var baseTimePerMB = 1000; // Tiempo base en milisegundos por MB

  if (files.length > 0) {
    // Limpiar iconos previos y mostrar el círculo de carga
    $("#fileIcons").empty();
    $("#loadingCircle").show();

    var totalSize = 0;
    var validFiles = [];

    // Filtrar archivos no válidos y calcular el tamaño total
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      if (file.type.startsWith("image/")) {
        validFiles.push(file);
        totalSize += file.size;
      } else {
        alert("Solo se permiten imágenes. Archivo ignorado: " + file.name);
      }
    }

    var totalSizeMB = totalSize / (1024 * 1024); // Convertir bytes a MB
    var estimatedTime = Math.max(totalSizeMB * baseTimePerMB, 2000); // Tiempo mínimo de 2000ms

    // Simular una carga de archivo
    setTimeout(function () {
      $("#loadingCircle").hide();

      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var fileIcon =
          '<img src="../../public/img/faq-3.png" style="width: 40px;height: 40px;margin-top: 10px;" alt="' +
          file.name +
          '">';
        $("#fileIcons").append(fileIcon);
      }
    }, estimatedTime);
  }
});
init();
