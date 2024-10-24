var initialData = {};

function init() {
  buscarDatos();
}
function buscarDatos() {
  $.post(
    "../../controller/usuario.php?op=mostrar",
    { usu_id: usu_id },
    function (data) {
      data = JSON.parse(data);

      var estado, cargo, direccion, ciudad, departamento;
      if (data.usu_est == 1) {
        estado = "Activo";
        clase = "label label-success";
      } else {
        estado = "Inactivo";
        clase = "label label-warning";
      }
      $("#estado").text(estado).attr("class", clase);
      $("#usu_cc").val(data.usu_cc);
      $("#usu_nom").val(data.usu_nom);
      cargo = data.detu_car ? data.detu_car.toUpperCase() : "";
      $("#cli_cargo").val(cargo);
      $("#usu_gcom").val(data.gcom_nom);
      $("#usu_tipcontrato").val(data.tipo_contrato);
      $("#usu_feingreso").val(data.detu_feing);

      $("#usu_user").val(data.usu_user);

      $("#usu_fenac").val(data.fecha_nac);
      $("#usu_telefono").val(data.detu_tel);
      $("#usu_celular").val(data.detu_cel);
      $("#usu_mail").val(data.detu_cor);
      direccion = data.detu_dir ? data.detu_dir.toUpperCase() : "";
      $("#usu_direccion").val(direccion);
      ciudad = data.detu_ciu ? data.detu_ciu.toUpperCase() : "";
      $("#usu_ciudad").val(ciudad);
      departamento = data.detu_dep ? data.detu_dep.toUpperCase() : "";
      $("#usu_dep").val(departamento);

      // Guardar los valores iniciales
      initialData = {
        detu_tel: data.detu_tel,
        detu_cel: data.detu_cel,
        detu_cor: data.detu_cor,
        detu_dir: direccion,
        detu_ciu: ciudad,
        detu_dep: departamento,
        detu_fenac: data.fecha_nac,
      };
    }
  );
}
$("#Editar").on("click", function () {
  if ($("#Editar").text() == "Editar") {
    $("#usu_telefono").prop("disabled", false);
    $("#usu_celular").prop("disabled", false);
    $("#usu_mail").prop("disabled", false);
    $("#usu_direccion").prop("disabled", false);
    $("#usu_ciudad").prop("disabled", false);
    $("#usu_dep").prop("disabled", false);
    $("#usu_fenac").prop("disabled", false);
    $("#Editar").text("Cancelar");
    $("#Guardar").removeAttr("disabled");
  } else {
    // Restaurar los valores iniciales
    $("#usu_telefono").val(initialData.detu_tel).prop("disabled", true);
    $("#usu_celular").val(initialData.detu_cel).prop("disabled", true);
    $("#usu_mail").val(initialData.detu_cor).prop("disabled", true);
    $("#usu_direccion")
      .val(initialData.detu_dir ? initialData.detu_dir.toUpperCase() : "")
      .prop("disabled", true);
    $("#usu_ciudad")
      .val(initialData.detu_ciu ? initialData.detu_ciu.toUpperCase() : "")
      .prop("disabled", true);
    $("#usu_dep")
      .val(initialData.detu_dep ? initialData.detu_dep.toUpperCase() : "")
      .prop("disabled", true);
    $("#usu_fenac").val(initialData.detu_fenac).prop("disabled", true);

    $("#Editar").text("Editar");
    $("#Guardar").prop("disabled", true);
  }
});
$("#Guardar").on("click", function () {
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

  var formData = {
    usu_id: usu_id,
    usu_fnac: fechaValida,
    usu_telefono: $("#usu_telefono").val(),
    usu_celular: $("#usu_celular").val(),
    usu_mail: $("#usu_mail").val(),
    usu_direccion: $("#usu_direccion").val(),
    usu_ciudad: $("#usu_ciudad").val(),
    usu_dep: $("#usu_dep").val(),
  };
  $.ajax({
    url: "../../controller/usuario.php?op=editarUsu",
    type: "POST",
    data: formData,
    success: function (data) {
      buscarDatos();
      $("#usu_telefono").prop("disabled", true);
      $("#usu_celular").prop("disabled", true);
      $("#usu_mail").prop("disabled", true);
      $("#usu_direccion").prop("disabled", true);
      $("#usu_ciudad").prop("disabled", true);
      $("#usu_dep").prop("disabled", true);
      $("#usu_fenac").prop("disabled", true);
      $("#Guardar").prop("disabled", true);
      $("#Editar").text("Editar");
      swal({
        title: "BYAPPS::CRM",
        text: "Usuario Actualizado con exito.",
        type: "success",
        confirmButtonClass: "btn-success",
      });
    },
    error: function (xhr, status, error) {
      swal("Error!", "Error en la solicitud: " + error, "warning");
    },
  });
});
$("#Cambiarpass").on("click", function () {
  var nuevac = $("#n_pass").val();
  var rnuevac = $("#rn_pass").val();

  if (nuevac == rnuevac) {
    var formData = {
      usu_id: usu_id,
      nuevac: nuevac,
      rnuevac: rnuevac,
    };

    swal(
      {
        title: "BYAPPS::CRM",
        text: "Esta seguro de Cambiar su contraseña?",
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
            "../../controller/usuario.php?op=editarCont",
            formData,
            function (data) {
              if (data == "1" || data == "Exito") {
                $("#n_pass").val("");
                $("#rn_pass").val("");

                var tipo = "Seguridad";
                var detalle = "Cambio de contraseña";
                $.ajax({
                  url: "../../controller/logs.php?op=logs",
                  type: "POST",
                  data: JSON.stringify({
                    tipo: tipo,
                    detalle: detalle,
                  }),
                  contentType: "application/json",
                  processData: false,
                  success: function (response) {},
                });

                swal({
                  title: "BYAPPS::CRM",
                  text: "Contraseña Actualizada con exito.",
                  type: "success",
                  confirmButtonClass: "btn-success",
                });
              } else {
                $("#n_pass").val("");
                $("#rn_pass").val("");
                swal("Error!", "Error al gestionar la solicitud", "warning");
              }
            }
          );
        }
      }
    );
  } else {
    swal({
      title: "BYAPPS::CRM",
      text: "Las contraseñas son diferentes.",
      type: "warning",
      confirmButtonClass: "btn-success",
    });
  }
});
init();
