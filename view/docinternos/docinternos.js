var idcat;
var label;
var inicio = true;

function init() {
  listarcategorias();
}
//-----CATEGORIAS-------------
function listarcategorias() {
  $.ajax({
    url: "../../controller/documentosinternos.php?op=buscarcategorias",
    method: "POST",
    success: function (response) {
      var $lista = $(".files-manager-side-list");
      // Limpiar elementos existentes, excluyendo los dividers
      $lista.find("li:not(.dropdown-divider)").remove();
      // $lista.find(".dropdown-divider").remove();
      $lista.append('<div class="dropdown-divider"></div>');
      // Iterar sobre las categorías recibidas y agregar nuevas listas <li>
      $(response).each(function (index, item) {
        var $nuevoElemento = $('<li><a href="#">' + item.label + "</a></li>");
        $nuevoElemento.data("index", item.value);
        $nuevoElemento.data("label", item.label);
        $lista.append($nuevoElemento);
      });
      if (
        usu_perfil != "Calidad" &&
        usu_perfil != "Operativo" &&
        usu_perfil != "Coordinador" &&
        usu_perfil != "Asesor"
      ) {
        $lista.append('<div class="dropdown-divider"></div>');
        var $papeleraElemento = $(
          '<li><a href="#" class="3">PAPELERA</a></li>'
        );
        $papeleraElemento.data("index", 0);
        $papeleraElemento.data("label", "PAPELERA");
        $lista.append($papeleraElemento);
      }
      // Agregar manejador de eventos click a los elementos de la lista
      $lista.find("li a").click(function (e) {
        e.preventDefault();
        var $parent = $(this).parent();
        idcat = $parent.data("index");
        label = $parent.data("label");
        // Ocultar el icono de edición si la categoría es "Papelera" o "Sin categoría"
        if (
          usu_perfil != "Calidad" &&
          usu_perfil != "Operativo" &&
          usu_perfil != "Coordinador" &&
          usu_perfil != "Asesor"
        ) {
          if (label === "PAPELERA" || label === "SIN CATEGORIA") {
            $("#edit-icon").hide();
            $("#eliminarcat").hide();
          } else {
            $("#edit-icon").show();
            $("#eliminarcat").show();
          }
        } else {
          $("#edit-icon").hide();
          $("#eliminarcat").hide();
        }
        if (idcat !== undefined) {
          $("#nomcat").html(label);
          buscarDocumentos(idcat);
        } else {
          swal("Elemento sin índice asociado.");
        }
      });
      // Buscar documentos para el primer elemento de la lista
      if (inicio) {
        var $primerElemento = $lista
          .find("li")
          .not(".dropdown-divider")
          .first();
        if ($primerElemento.length > 0) {
          var primerIndex = $primerElemento.data("index");
          var primerLabel = $primerElemento.data("label");
          label = primerLabel;
          // Ocultar el icono de edición si la categoría es "Papelera" o "Sin categoría"
          if (label === "PAPELERA" || label === "SIN CATEGORIA") {
            $("#edit-icon").hide();
            $("#eliminarcat").hide();
          } else {
            $("#edit-icon").show();
            $("#eliminarcat").show();
          }

          if (primerIndex !== undefined) {
            $("#nomcat").text(primerLabel);
            buscarDocumentos(primerIndex);
          }
        }
      }
    },
    error: function (error) {
      swal("Error al listar categorías:", error);
    },
  });
}
$(document).on("click", "#btn_newcat", function () {
  $("#mdltitulo2").html("Crear Categoria");
  $("#modalcategoria").modal("show");
});
$("#categoria_form").on("submit", function (e) {
  e.preventDefault();
  var nombrecat = $("#cat_nombre").val();
  $.ajax({
    url: "../../controller/documentosinternos.php?op=crearcategoria",
    type: "POST",
    data: { nombrecat: nombrecat },
    success: function (datos) {
      $("#categoria_form")[0].reset();
      //   /* TODO:Ocultar Modal */
      $("#modalcategoria").modal("hide");
      listarcategorias();

      //   /* TODO:Mensaje de Confirmacion */
      swal({
        title: "BYAPPS::CRM",
        text: "Categoria Creada Correctamente.",
        type: "success",
        confirmButtonClass: "btn-success",
      });
    },
  });
});
$("#edit-icon").click(function () {
  var $icon = $(this).find("i");
  var $h3 = $("#nomcat");
  if ($icon.hasClass("glyphicon-pencil")) {
    $icon.removeClass("glyphicon-pencil").addClass("glyphicon-floppy-disk");
    var text = $h3.text();
    $h3.html('<input type="text" id="edit-input" value="' + text + '">');
    // Cambiar el tooltip a "Guardar"
    $(this).attr("data-tooltip", "Guardar");
    $(this).attr("data-title", "Guardar");
    $(this).attr("title", "Guardar");
    $(this)
      .tooltip("hide")
      .attr("data-original-title", "Guardar")
      .tooltip("show");
  } else {
    $icon.removeClass("glyphicon-floppy-disk").addClass("glyphicon-pencil");
    var newText = $("#edit-input").val();
    $h3.text(newText);
    $(this).attr("data-tooltip", "Editar");
    $(this).attr("data-title", "Editar");
    $(this).attr("title", "Editar");
    $(this)
      .tooltip("hide")
      .attr("data-original-title", "Editar")
      .tooltip("show");
    if (newText != label) {
      $.ajax({
        url: "../../controller/documentosinternos.php?op=guardar_titulo",
        method: "POST",
        data: { idcat: idcat, titulo: newText },
        success: function (response) {
          inicio = false;
          listarcategorias();
        },
        error: function (error) {
          swal("Error al guardar el título:", error);
        },
      });
    }
  }
});
$(document).on("click", "#eliminarcat", function () {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "Esta seguro de Eliminar la categoria?",
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
          "../../controller/documentosinternos.php?op=eliminarcategoria",
          { idcat: idcat },
          function (data) {}
        );
        idcat = undefined;
        listarcategorias();

        swal({
          title: "BYAPPS::CRM",
          text: "Categoria Eliminada.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    }
  );
});
function categoriascombo(cat) {
  $.ajax({
    url: "../../controller/documentosinternos.php?op=buscarcategorias",
    method: "POST",
    success: function (response) {
      $("#cat").html(response);

      // Si el valor de cat no es "no", selecciona el valor en el dropdown
      if (cat != "no") {
        $("#cat").val(cat);
      }
    },
    error: function (error) {
      swal("Error al listar categorías:", error);
    },
  });
}
//----------------------------
//-----DOCUMENTOS-------------
function buscarDocumentos(idcatd) {
  $("#entidad_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ordering: false,
    ajax: {
      url: "../../controller/documentosinternos.php?op=documentosxidcat",
      type: "post",
      dataType: "json",
      data: {
        idcat: idcatd,
        label: label,
      },
      error: function (e) {
        swal(e.responseText);
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
$(document).on("click", "#btnnuevo", function () {
  $("#documentoin_form")[0].reset();
  $("#mdltitulo").html("Nuevo Documento");
  categoriascombo("no");
  $("#doc").show();
  /* TODO:Mostrar Modal */
  $("#modaldocumento").modal("show");
});
$("#documentoin_form").on("submit", function (e) {
  guardaryeditar(e);
});
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#documentoin_form")[0]);
  formData.append("usu_id", usu_id);
  // Verificar si se ha seleccionado un documento si estamos en nuevo doc
  if ($("#mdltitulo").html() == "Nuevo Documento") {
    if ($("#fileTest")[0].files.length === 0) {
      swal("Por favor, seleccione un documento antes de guardar.");
      return;
    }
  }
  $.ajax({
    url: "../../controller/documentosinternos.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#documentoin_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaldocumento").modal("hide");
        $("#entidad_data").DataTable().ajax.reload();

        //   /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Documento Guardado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#documentoin_form")[0].reset();
        //   /* TODO:Ocultar Modal */
        $("#modaldocumento").modal("hide");
        $("#entidad_data").DataTable().ajax.reload();

        //   /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Documento Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      }
    },
  });
}
function datos(rutadoc) {
  window.open(rutadoc, "_blank");
}
function editardi(id, nom, cls, est) {
  categoriascombo(cls);
  $("#catid").val(id);
  $("#docnom").val(nom);
  $("#cat_est").val(est);
  $("#mdltitulo").html("Editar Documento");
  $("#doc").hide();

  $("#modaldocumento").modal("show");
}
function eliminar(doci_id) {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "Esta seguro de Eliminar el documento?",
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
          "../../controller/documentosinternos.php?op=cambiarestadoeliminado",
          { doci_id: doci_id },
          function (data) {}
        );

        $("#entidad_data").DataTable().ajax.reload();

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
//----------------------------
$("#fileTest").on("change", function () {
  var fileInput = $(this);
  var files = fileInput[0].files;
  var baseTimePerMB = 1000; // Tiempo base en milisegundos por MB

  if (files.length > 0) {
    // Limpiar iconos previos y mostrar el círculo de carga
    $("#fileIcons").empty();
    $("#loadingCircle").show();

    var totalSize = 0;
    for (var i = 0; i < files.length; i++) {
      totalSize += files[i].size;
    }
    var totalSizeMB = totalSize / (1024 * 1024);
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
