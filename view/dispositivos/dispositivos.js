function init() {}

$(document).ready(function () {});

function huellapc() {
  (async () => {
    // Carga la biblioteca FingerprintJS
    const fp = await FingerprintJS.load();

    // Obtiene la huella digital
    const result = await fp.get();

    // Obtiene el identificador único del visitante
    const visitorId = result.visitorId;

    // Aquí puedes enviar el visitorId al servidor o realizar otra acción necesaria
    // console.log("Visitor ID:", visitorId);

    // Puedes agregar código adicional para manejar el visitorId como lo necesites
    // Por ejemplo, enviarlo al servidor mediante AJAX
    $.ajax({
      url: "../../controller/usuario.php?op=autorizacion",
      method: "POST",
      data: { visitorId: visitorId },
      success: function (response) {
        // console.log("Huella registrada correctamente:", response);
        // Aquí puedes manejar la respuesta del servidor si es necesario
      },
      error: function (xhr, status, error) {
        console.error("Error al registrar la huella:", error);
        // Manejar errores aquí
      },
    });
  })();
}

$("#btnnuevo").on("click", function () {
  huellapc();
});

init();
