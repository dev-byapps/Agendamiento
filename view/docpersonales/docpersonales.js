var inicio = true;
var idcat;
var label;

function init() {
  // console.log(usu_perfil);
  if (usu_perfil == "Administrador") {
    $("#btn_newcat").show();
  } else {
    $("#btn_newcat").hide();
  }
  buscarusuarios();
}
function buscarusuarios() {
  if (
    usu_perfil == "Calidad" ||
    usu_perfil == "Operativo" ||
    usu_perfil == "Coordinador" ||
    usu_perfil == "Asesor"||
    usu_perfil == "Agente"||
    usu_perfil == "Asesor/Agente"

  ) {
    $.post("../../controller/usuario.php?op=usuario", function (data, status) {
      $("#asesor").html(data);
      $("#div_cat").css("display", "");
      listarcategorias();
    });
  } else {
    $.ajax({
      url: "../../controller/usuario.php?op=admin",
      method: "POST",
      success: function (response) {
        $("#asesor").html(response);
        $("#div_cat").css("display", "");
        listarcategorias();
      },
      error: function (error) {
        swal("Error al listar categorías:", error);
      },
    });
  }
}
// -------- CATEGORIAS-----------
function listarcategorias() {
  $.ajax({
    url: "../../controller/documentospersonales.php?op=buscarcategorias",
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
        $nuevoElemento.data("index", item.value); // Guardar el índice en el elemento
        $nuevoElemento.data("label", item.label); // Guardar el nombre de la categoría en el elemento
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
          $("#tabla").css("display", "");
          buscarDocumentos(idcat);
        } else {
          swal("Elemento sin índice asociado.");
        }
      });

      // Buscar documentos para el primer elemento de la lista que no sea un divider
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
            $("#tabla").css("display", "");
            idcat = primerIndex;
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
function categoriascombo(cat) {
  $.ajax({
    url: "../../controller/documentospersonales.php?op=buscarcategorias",
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
$(document).on("click", "#btn_newcat", function (e) {
  e.preventDefault();
  $("#mdltitulo2").html("Crear Categoria");
  $("#modalcategoria").modal("show");
});
$("#categoria_form").on("submit", function (e) {
  e.preventDefault();
  var nombrecat =
    $("#cat_nombre").val().charAt(0).toUpperCase() +
    $("#cat_nombre").val().slice(1).toLowerCase();
  $.ajax({
    url: "../../controller/documentospersonales.php?op=crearcategoria",
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
    // Cambiar el tooltip a "Editar"
    $(this).attr("data-tooltip", "Editar");
    $(this).attr("data-title", "Editar");
    $(this).attr("title", "Editar");
    $(this)
      .tooltip("hide")
      .attr("data-original-title", "Editar")
      .tooltip("show");

    if (newText != label) {
      newText =
        newText.charAt(0).toUpperCase() + newText.slice(1).toLowerCase();
      // Enviar solicitud AJAX para guardar el nuevo valor
      $.ajax({
        url: "../../controller/documentospersonales.php?op=guardar_titulo",
        method: "POST",
        data: { idcat: idcat, titulo: newText },
        success: function (response) {
          inicio = false;
          $("#nomcat").text(newText);
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
          "../../controller/documentospersonales.php?op=eliminarcategoria",
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
//-------------------------------
// -------- DOCUMENTOS-----------
function buscarDocumentos(idcatd) {
  var usu = $("#asesor").val();
  $("#docper_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ordering: false,
    ajax: {
      url: "../../controller/documentospersonales.php?op=documentosxidcat",
      type: "post",
      dataType: "json",
      data: {
        idcat: idcatd,
        label: label,
        usu: usu,
        usu_perfil: usu_perfil,
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
$(document).on("click", "#btnnuevo", function (e) {
  e.preventDefault();
  $("#documentoin_form")[0].reset();
  $("#mdltitulo").html("Nuevo Documento");
  categoriascombo("no");
  $("#doc").show();
  $("#modaldocumento").modal("show");
});
$("#documentoin_form").on("submit", function (e) {
  guardaryeditar(e);
});
$(document).on("change", "#asesor", function () {
  buscarDocumentos(idcat);
});
function guardaryeditar(e) {
  e.preventDefault();
  var asignado = $("#asesor").val();
  var formData = new FormData($("#documentoin_form")[0]);
  formData.append("usu_id", asignado);
  formData.append("creado", usu_id);

  // Verificar si se ha seleccionado un documento si estamos en nuevo doc
  if ($("#mdltitulo").html() == "Nuevo Documento") {
    if ($("#fileTest")[0].files.length === 0) {
      swal("Por favor, seleccione un documento antes de guardar.");
      return;
    }
  }
  $.ajax({
    url: "../../controller/documentospersonales.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#documentoin_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaldocumento").modal("hide");
        $("#docper_data").DataTable().ajax.reload();

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
        $("#docper_data").DataTable().ajax.reload();

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
function datos(rutdoc) {
  window.open(rutdoc, "_blank");
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
          "../../controller/documentospersonales.php?op=cambiarestadoeliminado",
          { doci_id: doci_id },
          function (data) {}
        );

        $("#docper_data").DataTable().ajax.reload();

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
//-------------------------------
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
