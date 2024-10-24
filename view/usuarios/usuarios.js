var tabla;

function init() {
  $("#rol_id").select2({
    dropdownParent: $("#modalmantenimiento"),
  });
}
$(document).ready(function () {
  listar();
});
function listar() {
  tabla = $("#usuario_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/usuario.php?op=listar",
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
function editar(id, us, pa, pe, es, td, cc, no, ape, ma, ca, con, gc, fi, fr) {
  get_grupocom()
    .then(() => {
      $("#mdltituloma").html("Editar Usuario");

      $("#usu_id").val(id);
      $("#usu_user").val(us);
      $("#usu_pass").val(pa);
      $("#usu_perfil").val(pe);
      $("#usu_est").val(es);
      $("#usu_tipodoc").val(td);
      $("#usu_cc").val(cc);
      $("#usu_nom").val(no);
      $("#usu_ape").val(ape);

      $("#usu_mail").val(ma);
      $("#usu_mail").removeClass("form-control-error");
      $("#usu_mail + small").remove();

      $("#usu_car").val(ca);
      $("#usu_tipcontrato").val(con);

      var usu_grupocom = gc;
      if (usu_grupocom != "" && usu_grupocom != null) {
        $("#usu_grupocom").val(usu_grupocom).trigger("change");
      } else {
        $("#usu_grupocom").val("0");
      }

      $("#tar_fingreso").val(fi);
      $("#usu_feretiro").val(fr);

      /* TODO: Mostrar Modal */
      $("#modalmantenimiento").modal("show");
    })
    .catch((error) => {
      swal("Error al cargar los datos de grupocom:", error);
    });
}
function get_grupocom() {
  return new Promise((resolve, reject) => {
    $.post("../../controller/grupocom.php?op=admin", function (data) {
      // Limpiar el select antes de agregar nuevas opciones
      $("#usu_grupocom").empty();

      if (data.trim() === "") {
        $("#usu_grupocom").append("<option value='0'>Sin grupocom</option>");
        $("#usu_grupocom").val(0);
      } else {
        $("#usu_grupocom").html(data);
      }

      // Resolviendo la promesa después de que los datos hayan sido cargados
      resolve();
    }).fail(function (error) {
      // Rechazar la promesa si hay un error en la solicitud
      reject(error);
    });
  });
}
$("#usuario_form").on("submit", function (e) {
  e.preventDefault();
  // Expresión regular para validar el formato d/m/y
  var formatoFecha = /^\d{2}\/\d{2}\/\d{4}$/;

  // Obtener el valor del campo de fecha de nacimiento
  var fechaIngreso = $("#tar_fingreso").val();
  var fechaValidaIngreso;

  if (fechaIngreso === "") {
    // Si el campo está vacío, asignar 0 a la variable
    fechaValidaIngreso = "0000-00-00";
  } else if (formatoFecha.test(fechaIngreso)) {
    // Si la fecha tiene el formato d/m/y, asignarla a la variable
    fechaValidaIngreso = fechaIngreso;
  } else {
    swal({
      icon: "error",
      title: "Formato Incorrecto",
      text: "La fecha de Ingreso debe ser en formato dd/mm/yyyy.",
      confirmButtonText: "Aceptar",
    });
    return;
  }

  var fechaRetiro = $("#usu_feretiro").val();
  var fechaValidaRetiro;

  if (fechaRetiro === "") {
    // Si el campo está vacío, asignar 0 a la variable
    fechaValidaRetiro = "0000-00-00";
  } else if (formatoFecha.test(fechaRetiro)) {
    // Si la fecha tiene el formato d/m/y, asignarla a la variable
    fechaValidaRetiro = fechaRetiro;
  } else {
    swal({
      icon: "error",
      title: "Formato Incorrecto",
      text: "La fecha de Retiro debe ser en formato dd/mm/yyyy.",
      confirmButtonText: "Aceptar",
    });
    return;
  }

  
  if ($("#mdltituloma").text() == "Nuevo Usuario") {
    // validar que el ususario no exista
    no_usurep();
  } else {
    var d = true;
    guardaryeditar(d);
  }
});
function no_usurep() {
  var usu = $("#usu_user").val();

  $.post(
    "../../controller/usuario.php?op=nousurep",
    { usuario: usu },
    function (data) {
      try {
        var response = JSON.parse(data);
        if (
          response[0]["count(usu_id)"] == 0 ||
          response[0]["count(usu_id)"] == "0"
        ) {
          var d = true;
          guardaryeditar(d);
        } else {
          swal("Error: Usuario ya existe.");
        }
      } catch (e) {
        swal("Error al buscar usuario: ", e);
      }
    }
  );
}
function guardaryeditar(d) {
  var formData = "";
  if (d) {
    formData = new FormData($("#usuario_form")[0]);
  } else {
    formData = new FormData($("#info_form")[0]);
  }

  $.ajax({
    url: "../../controller/usuario.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#usuario_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#usuario_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#usuario_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#usuario_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "3") {
        $("#info_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalinformacion").modal("hide");
        $("#usuario_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "0") {
        $("#usu_user").addClass("form-control-error");
        $(
          "<small class='text-muted text-danger'>El Registro ya existe</small>"
        ).insertAfter("#usu_user");
      }
    },
  });
}
function datos(usu_id) {
  $("#mdltitulo").html("Información de Usuario");

  $.post(
    "../../controller/usuario.php?op=mostrar",
    { usu_id: usu_id },
    function (data) {
      data = JSON.parse(data);
      $("#usuid").val(data.usu_id);
      $("#usu_fenac").val(data.fecha_nac);

      $("#usu_tel").val(data.detu_tel);
      $("#usu_cel").val(data.detu_cel);
      $("#usu_dir").val(data.detu_dir);
      $("#usu_ciu").val(data.detu_ciu);
      $("#usu_dep").val(data.detu_dep);
    }
  );

  /* TODO: Mostrar Modal */
  $("#modalinformacion").modal("show");
}
$("#guardarform").on("click", function (e) {
  e.preventDefault();
  // Obtener el valor del campo de fecha de nacimiento
  var fechaNacimiento = $("#usu_fenac").val();
  var fechaValida;

  // Expresión regular para validar el formato d/m/y
  var formatoFecha = /^\d{2}\/\d{2}\/\d{4}$/;

  if (fechaNacimiento === "") {
    // Si el campo está vacío, asignar 0 a la variable
    fechaValida = "0000-00-00";
  } else if (formatoFecha.test(fechaNacimiento)) {
    // Si la fecha tiene el formato d/m/y, asignarla a la variable
    fechaValida = fechaNacimiento;
  } else {
    swal({
      icon: "error",
      title: "Formato Incorrecto",
      text: "La fecha de nacimiento debe ser en formato dd/mm/yyyy.",
      confirmButtonText: "Aceptar",
    });
    return;
  }

  var d = false;
  guardaryeditar(d);
});
function sip(usu_id) {
  $("#usu_ext").val();
  $("#usu_passip").val();

  $.post(
    "../../controller/usuario.php?op=datossip",
    { usu_id: usu_id },
    function (data) {
      data = JSON.parse(data);

      if (Array.isArray(data) && data.length > 0) {
        $("#usu").val(usu_id);
        $("#usu_ext").val(data[0].sip_ext);
        $("#usu_passip").val(data[0].sip_pass);
      } else {
        $("#usu").val(usu_id);
        $("#usu_ext").val("");
        $("#usu_passip").val("");
      }
    }
  );

  /* TODO: Mostrar Modal */
  $("#modalsip").modal("show");
}
$("#sip_form").on("submit", function (e) {
  e.preventDefault();
  var formData = new FormData($("#sip_form")[0]);

  $.ajax({
    url: "../../controller/usuario.php?op=editarsip",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      $("#sip_form")[0].reset();
      $("#modalsip").modal("hide");
      $("#usuario_data").DataTable().ajax.reload();

      swal({
        title: "BYAPPS::CRM",
        text: "Registrado Correctamente.",
        type: "success",
        confirmButtonClass: "btn-success",
      });
    },
  });
});
function eliminar(usu_id) {
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
          "../../controller/usuario.php?op=eliminar",
          { usu_id: usu_id },
          function (data) {}
        );

        $("#usuario_data").DataTable().ajax.reload();

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
  get_grupocom();
  $("#usu_id").val("");
  $("#usuid").val("");
  $("#mdltituloma").text("Nuevo Usuario");
  $("#usuario_form")[0].reset();

  $("#usu_mail").removeClass("form-control-error");
  $("#usu_mail + small").remove();

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
  tabla = $("#usuario_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/usuario.php?op=listarInactivos",
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
