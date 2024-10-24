var $asunto = $("#asunto_sop");
var $contacto = $("#contacto_sop");
var $mensaje = $("#mensaje_sop");
var asunto;
var contacto;
var mensaje;
var formData;

function init() {}

$asunto.on("blur", function () {
  asunto = $asunto.val();
  if (asunto === "") {
    if ($asunto.next(".1").length === 0) {
      $(
        "<small class='text-muted text-danger 1'>No has escrito ningún asunto</small>"
      ).insertAfter($asunto);
    }
  } else {
    $asunto.next(".1").remove();
  }
});

$contacto.on("blur", function () {
  contacto = $contacto.val();
  if (contacto === "") {
    if ($contacto.next(".2").length === 0) {
      $(
        "<small class='text-muted text-danger 2'>No has escrito ningún contácto</small>"
      ).insertAfter($contacto);
    }
  } else {
    $contacto.next(".2").remove();
  }
});

$mensaje.on("blur", function () {
  mensaje = $mensaje.val();
  if (mensaje === "") {
    if ($mensaje.next(".text-danger").length === 0) {
      $(
        "<small class='text-muted text-danger'>No has escrito ningún mensaje</small>"
      ).insertAfter($mensaje);
    }
  } else {
    $mensaje.next(".text-danger").remove();
  }
});

$("#enviarEmail").on("click", function (e) {
  if (
    asunto === "" ||
    contacto === "" ||
    mensaje === "" ||
    asunto === undefined ||
    contacto === undefined ||
    mensaje === undefined
  ) {
    e.preventDefault(); // Cancelar el envío del formulario si hay campos vacíos
    if (asunto === "" || asunto === undefined) {
      if ($asunto.next(".1").length === 0) {
        $(
          "<small class='text-muted text-danger 1'>No has escrito ningún asunto</small>"
        ).insertAfter($asunto);
      }
    }
    if (contacto === "" || contacto === undefined) {
      if ($contacto.next(".2").length === 0) {
        $(
          "<small class='text-muted text-danger 2'>No has escrito ningún contácto</small>"
        ).insertAfter($contacto);
      }
    }
    if (mensaje === "" || mensaje === undefined) {
      if ($mensaje.next(".text-danger").length === 0) {
        $(
          "<small class='text-muted text-danger'>No has escrito ningún mensaje</small>"
        ).insertAfter($mensaje);
      }
    }
  } else {
    formData = new FormData($("#soporte_form")[0]);

    $.ajax({
      url: "../../controller/soporte.php?op=enviar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        // console.log(response);
        // var data = JSON.parse(response);
        if (response == "El Mensaje ha sido enviado") {
          swal("success", "Correo Enviado Exitosamente", "success");
        } else {
          swal("Error", data.message, "error");
        }
      },
    });
    return false;
  }
});

init();
