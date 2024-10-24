function init() {
  listar_entidades();
}
function listar_entidades() {
  $.post("../../controller/entidad.php?op=comboent", function (data, status) {
    var campotodo = '<option value="0">Todo</option>' + data;
    $("#fil_entidad").html(campotodo);
    $("#fil_entidad_ope").html(campotodo);
    listar_gruposcom();
  });
}
function listar_gruposcom() {
  $.post("../../controller/grupocom.php?op=admin", function (data, status) {
    var campotodo = '<option value="0">Todo</option>' + data;
    $("#fil_grupo").html(campotodo);
    $("#fil_grupo_ope").html(campotodo);
    listar_asesores();
  });
}
function listar_asesores() {
  $.post("../../controller/usuario.php?op=admin", function (data, status) {
    var campotodo = '<option value="0">Todo</option>' + data;
    $("#fil_asesor").html(campotodo);
    $("#fil_asesor_ope").html(campotodo);
    $("#generar_consulta").prop("disabled", false);
    $("#generar_ope").prop("disabled", false);
  });
}

$(document).on("click", "#generar_consulta", function (e) {
  e.preventDefault();
  var formData = new FormData($("#consultas_form")[0]);

  fetch("../../controller/informe.php?op=inf_consultas", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      console.log(response);
      // Verificar el tipo de contenido de la respuesta
      if (response.headers.get("Content-Type").includes("application/json")) {
        return response.json(); // Leer JSON si es una respuesta de error
      }
      return response.blob(); // Leer el archivo si es una respuesta de archivo
    })
    .then((data) => {
      console.log(data);
      if (data.error) {
        // Mostrar mensaje de error
        Swal.fire({
          icon: "warning",
          title: "Sin datos",
          text: data.error,
        });
      } else {
        // Crear un enlace para descargar el archivo
        var url = window.URL.createObjectURL(data);
        var a = document.createElement("a");
        a.href = url;
        a.download = "informe_consultas.xlsx"; // Nombre del archivo a descargar
        document.body.appendChild(a);
        a.click(); // Iniciar la descarga
        a.remove(); // Limpiar
      }
    })
    .catch((error) => console.error("Error al generar el archivo:", error));
});

$(document).on("click", "#generar_ope", function (e) {
  e.preventDefault();
  var formData = new FormData($("#operaciones_form")[0]);

  $.ajax({
    url: "../../controller/informe.php?op=inf_operaciones",
    type: "POST",
    data: formData,
    processData: false, // Necesario para que jQuery no procese los datos
    contentType: false, // Necesario para que jQuery no establezca ningÃºn tipo de contenido
    success: function (response) {
      var data = JSON.parse(response);

      if (data.file) {
        window.location.href = "../" + data.file;
      } else {
        swal({
          title: "Error",
          text: "No se pudo generar el archivo o no se encontraron datos",
          type: "error",
          confirmButtonClass: "btn-danger",
        });
      }
      //
    },
  });
});

init();
