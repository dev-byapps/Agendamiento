var filtro = "FALSE";
var pageLoaded = false;

function init() {}

$(document).ready(function () {
  listarDatos().then(() => {
    pageLoaded = true;
  });
  
  $("#daterange, #fil_entidad, #fil_grupo, #fil_asesor").on(
    "change",
    function (event) {
      if (!pageLoaded) {
        return;
      }

      let usuPerfil = $("#usu_perfil").val();

      if (event.target.id === "fil_grupo" && usuPerfil === "Administrador") {
        // El cambio fue en #fil_grupo
        $.post(
          "../../controller/usuario.php?op=usuxgrupocom",
          { grupocom_id: $("#fil_grupo").val() },
          function (data, status) {
            var campotodo = '<option value="0">Todo</option>' + data;
            $("#fil_asesor").html(campotodo);
            resolve();
          }
        )
      }

      filtro = "TRUE";
      filtrar();
    }
  );
});

function listarDatos() {
  return new Promise((resolve, reject) => {
    var grupoPromise, usuarioPromise;
    const entidadPromise = new Promise((resolve, reject) => {
      $.post(
        "../../controller/entidad.php?op=comboent",
        function (data, status) {
          var campotodo = '<option value="0">Todo</option>' + data;
          $("#fil_entidad").html(campotodo);
          resolve();
        }
      ).fail(reject);
    });

    entidadPromise
      .then(() => {
        if (
          usuPerfil == "Administrador" ||
          usuPerfil == "Gerencia" ||
          usuPerfil == "Calidad" ||
          usuPerfil == "Operativo" ||
          usuPerfil == "RRHH"
        ) {
          grupoPromise = new Promise((resolve, reject) => {
            $.post(
              "../../controller/grupocom.php?op=admin",
              function (data, status) {
                var campotodo = '<option value="0">Todo</option>' + data;
                $("#fil_grupo").html(campotodo);
                resolve();
              }
            ).fail(reject);
          });

          usuarioPromise = new Promise((resolve, reject) => {
            $.post(
              "../../controller/usuario.php?op=admin",
              function (data, status) {
                var campotodo = '<option value="0">Todo</option>' + data;
                $("#fil_asesor").html(campotodo);
                resolve();
              }
            ).fail(reject);
          });
        } else if (usuPerfil == "Coordinador") {
          if (usu_grupocom == "") {
            grupoPromise = new Promise((resolve) => {
              var campotodo = '<option value="0">Sin Grupo Comercial</option>';
              $("#fil_grupo").html(campotodo);
              resolve();
            });

            usuarioPromise = new Promise((resolve, reject) => {
              $.post(
                "../../controller/usuario.php?op=usuario",
                function (data, status) {
                  $("#fil_asesor").html(data);
                  resolve();
                }
              ).fail(reject);
            });
          } else {
            grupoPromise = new Promise((resolve, reject) => {
              $.post(
                "../../controller/grupocom.php?op=usuario",
                function (data, status) {
                  $("#fil_grupo").html(data);
                  resolve();
                }
              ).fail(reject);
            });

            usuarioPromise = new Promise((resolve, reject) => {
              $.post(
                "../../controller/usuario.php?op=director",
                function (data, status) {
                  var campotodo = '<option value="0">Todo</option>' + data;
                  $("#fil_asesor").html(campotodo);
                  resolve();
                }
              ).fail(reject);
            });
          }
        } else {
          if (usu_grupocom == "") {
            grupoPromise = new Promise((resolve) => {
              var campotodo = '<option value="0">Sin Grupo Comercial</option>';
              $("#fil_grupo").html(campotodo);
              resolve();
            });
          } else {
            grupoPromise = new Promise((resolve, reject) => {
              $.post(
                "../../controller/grupocom.php?op=usuario",
                function (data, status) {
                  $("#fil_grupo").html(data);
                  resolve();
                }
              ).fail(reject);
            });
          }

          usuarioPromise = new Promise((resolve, reject) => {
            $.post(
              "../../controller/usuario.php?op=usuario",
              function (data, status) {
                $("#fil_asesor").html(data);
                resolve();
              }
            ).fail(reject);
          });
        }

        return Promise.all([grupoPromise, usuarioPromise]);
      })
      .then(() => {
        filtrar();
        resolve();
      })
      .catch(reject);
  });
}
function filtrar() {
  var formData = new FormData($("#filtros_form")[0]);
  formData.append("filtro", filtro);
  localStorage.setItem("daterange", $("#daterange").val());
  localStorage.setItem("usu_perfil", $("#usu_perfil").val());
  localStorage.setItem("fil_entidad", $("#fil_entidad").val());
  localStorage.setItem("fil_grupo", $("#fil_grupo").val());
  localStorage.setItem("fil_asesor", $("#fil_asesor").val());
  localStorage.setItem("filtro", filtro);

  $.ajax({
    url: "../../controller/cliente.php?op=filtrar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      data = JSON.parse(data);
      $("#interesados").html(data.interesado);
      $("#citas").html(data.cita);
      $("#analisis").html(data.analisis);
      $("#consulta").html(data.consulta);
      $("#respuesta").html(data.viable);
      $("#oferta").html(data.oferta);
      $("#retoma").html(data.retoma);
      $("#noviable").html(data.noviable);
      $("#nointeresado").html(data.nointeresado);
      $("#operacion").html(data.operacion);
      $("#cerrado").html(data.cerrados);
    },
  });

  $.ajax({
    url: "../../controller/operacion.php?op=filtrarOpe",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      data = JSON.parse(data);
      $("#radicacion").html(data.radicacion);
      $("#devoluciones").html(data.devolucion);
      $("#negado").html(data.negado);
      $("#desembolsados").html(data.desembolsados);
      $("#proceso").html(data.proceso);
    },
  });

  $.ajax({
    url: "../../controller/operacion.php?op=filtrarsumaOpe",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      data = JSON.parse(data);
      var vradicacion = data.vradicacion;
      var vDevoluciones = data.vDevoluciones;
      var vDesembolsados = data.vDesembolsados;
      var vnegado = data.vnegado;
      var vproceso = data.vProceso;

      if (
        vradicacion == null ||
        vradicacion == undefined ||
        vradicacion == ""
      ) {
        vradicacion = 0;
      }
      if (
        vDevoluciones == null ||
        vDevoluciones == undefined ||
        vDevoluciones == ""
      ) {
        vDevoluciones = 0;
      }
      if (
        vDesembolsados == null ||
        vDesembolsados == undefined ||
        vDesembolsados == ""
      ) {
        vDesembolsados = 0;
      }
      if (vnegado == null || vnegado == undefined || vnegado == "") {
        vnegado = 0;
      }
      if (vproceso == null || vproceso == undefined || vproceso == "") {
        vproceso = 0;
      }

      vradicacion = Number(vradicacion).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
      });
      vDevoluciones = Number(vDevoluciones).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
      });
      vDesembolsados = Number(vDesembolsados).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
      });
      vnegado = Number(vnegado).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
      });
      vproceso = Number(vproceso).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
      });

      $("#vRadicacion").html(vradicacion);
      $("#vDevoluciones").html(vDevoluciones);
      $("#vDesembolsados").html(vDesembolsados);
      $("#vnegado").html(vnegado);
      $("#vProceso").html(vproceso);
    },
  });
}

//*****BOTONES*/
$(document).on("click", "#btntodo", function (e) {
  e.preventDefault();
  filtro = "FALSE";
  listarDatos();
});
$(document).on("click", "#btnInteresados", function (e) {
  e.preventDefault();
  botonSeleccionado = "Interesado";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnCitas", function (e) {
  e.preventDefault();
  botonSeleccionado = "Cita";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnAnalisis", function (e) {
  e.preventDefault();
  botonSeleccionado = "Analisis";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnConsulta", function (e) {
  e.preventDefault();
  botonSeleccionado = "Consulta";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnRespuesta", function (e) {
  e.preventDefault();
  botonSeleccionado = "Viable";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnOferta", function (e) {
  e.preventDefault();
  botonSeleccionado = "Oferta";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnRetoma", function (e) {
  e.preventDefault();
  botonSeleccionado = "Retoma";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnNoViables", function (e) {
  e.preventDefault();
  botonSeleccionado = "No Viable";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnNoInteresados", function (e) {
  e.preventDefault();
  botonSeleccionado = "No Interesado";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnOperacion", function (e) {
  e.preventDefault();
  botonSeleccionado = "Operacion";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnCerrados", function (e) {
  e.preventDefault();
  botonSeleccionado = "Cerrado";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listarcliente/";
});
$(document).on("click", "#btnradicacion", function (e) {
  e.preventDefault();
  botonSeleccionado = "Radicacion";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listaroperaciones/";
});
$(document).on("click", "#btnproceso", function (e) {
  e.preventDefault();
  botonSeleccionado = "Proceso";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listaroperaciones/";
});
$(document).on("click", "#btnDevoluciones", function (e) {
  e.preventDefault();
  botonSeleccionado = "Devolucion";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listaroperaciones/";
});
$(document).on("click", "#btnNegado", function (e) {
  e.preventDefault();
  botonSeleccionado = "Negado";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listaroperaciones/";
});
$(document).on("click", "#btnDesembolsados", function (e) {
  e.preventDefault();
  botonSeleccionado = "Desembolsado";
  localStorage.setItem("botonSeleccionado", botonSeleccionado);
  window.location.href = "../listaroperaciones/";
});

init();
