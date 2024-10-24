var idcam;
var countID;
var nombreTabla;
var nombreCampaña;
var idcli = "";
var observaciones;
var estado;
var agenda;
var hora;
var seleccion;
var tel;
var tel2;
var filtro;
var telen;
var seccion = document.getElementById("seleccion");
var siguiente = document.getElementById("siguiente");
var terminar = document.getElementById("terminar");
var guardar = document.getElementById("Guardar");
var sip_cuenta;
var sip_ext;
var sip_pass;
var telWindow;
var nombre;
var conve;
var tick_id, decoded_id, ids, intentos;
var motivo;
var pausaEnCurso = false;
var intentos2 = "";
var intervaloPausa;
var pausaEnCurso = false;

function init() {
  $("#buttonG").css("display", "none");
  $("#cli_depa").prop("readonly", false);
  siguiente.disabled = true;
  $(siguiente).css("background-color", "gray");
  $(siguiente).css("color", "white");
  const url = window.location.href;
  const params = new URLSearchParams(new URL(url).search);

  if (params.has("cam")) {
    tick_id = params.get("cam"); 

    console.log(tick_id);   

    decoded_id = decodeURIComponent(tick_id);
    idcam = decoded_id.replace(/\s/g, "+");

    console.log(idcam);

    filtro = false;
    $("#menu").prop("disabled", true);
    terminar.textContent = "Terminar";
    terminar.disabled = false;
  } else {
    const i_param = params.get("i");
    const decoded_i = decodeURIComponent(i_param);
    ids = decoded_i.replace(/\s/g, "+").split(",");
    idcli = ids[0];
    idcam = ids[1];
    filtro = true;
    terminar.textContent = "Volver";
    terminar.disabled = false;
    $("#menu").prop("disabled", false);
  }

  bdatosSIP();
}
$(document).ready(function () {
  ingreso();

  ciudad();
  convenio();
  entidad();
  estadoc();
  toma();
  agente();
  asesor();

  guardar.disabled = true;
});
function bdatosSIP() {
  $.post("../../controller/sip.php?op=dsip", function (response) {
    var data = JSON.parse(response);

    if (data.status === "success") {
      let resultado = data.data;

      if (resultado.length > 0) {
        let sipData = resultado[0];
        sip_cuenta = sipData.sip_cuenta;
        sip_ext = sipData.sip_ext;
        sip_pass = sipData.sip_pass;
        $("#tel").css("background-color", "");
        $("#tel").css("color", "");
        $("#tel").prop("disabled", false);
      }
    } else if (data.status === "error") {
      swal("No se encontraron datos de llamada, valida con tu supervisor", data.message);
    }
  }).fail(function (jqXHR, textStatus, errorThrown) {
    // Manejo de errores de la solicitud AJAX
    swal(
      "Ocurrió un error en la solicitud: " + textStatus + " - " + errorThrown
    );
  });
}
function ingreso() {
  if (filtro == true) {
    siguiente.disabled = true;
    $(siguiente).css("background-color", "gray");
    $(siguiente).css("color", "white");
    $("#textcont").hide();
    $(siguiente).hide();
    buscarDato();
  } else {
    $("#sec-campaña").show();
    $("#sec-comen").show();
    $(siguiente).show();
    $(siguiente).css("background-color", "gray");
    $(siguiente).css("color", "white");
    contactos();
    iniciarCampana();
  }
}
function buscarDato() {
  $.ajax({
    url: "../../controller/llamada.php?op=clillamada",
    type: "POST",
    data: { id_cli: idcli, cam: idcam },
    success: function (datos) {
      var data = JSON.parse(datos);
      intentos2 = data[0].INTENTOS;
      iniciarCampana();

      // Limpiar campos antes de agregar nuevos datos
      $("#cli_cc").val("");
      $("#cli_nombre").val("");
      $("#cli_telefono").val("");
      $("#cli_convenio").val("");
      $("#cli_edad").val("");
      $("#cli_ciudad").val("").trigger("change");
      $("#cli_depa").val("");
      $("#tel_alternativo").val("");
      $("#cli_mail").val("");
      idcli = data[0].id;
      var cc = data[0].CEDULA;
      tel = data[0].TELEFONO;
      tel2 = data[0].TELALTERNATIVO;
      nombre = data[0].NOMBRE;
      conve = data[0].CONVENIO;

      // Contenedor principal para datos
      $("#datosContainer").empty().css({
        backgroundColor: "#ffffff",
        overflow: "hidden",
        width: "100%",
        boxSizing: "border-box",
        padding: "10px",
        tableLayout: "fixed", // Hace que la tabla ocupe todo el ancho disponible
      });

      // Función para capitalizar la primera letra y convertir el resto a minúsculas
      function capitalizeFirstLetter(str) {
        if (!str) return ""; // Maneja casos donde str es null o vacío
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
      }

      // Función para crear fila de datos
      function createRow(label, value, iconId) {
        if (value === null || value.trim() === "") {
          return; // No crear la fila si el valor está vacío o es null
        }

        var row = $("<tr>").addClass("tbl-row").css({
          display: "table-row",
          marginBottom: "5px", // Separación entre filas
          width: "100%",
          boxSizing: "border-box",
        });

        var labelDiv = $("<td>")
          .addClass("tbl-cell tbl-cell-lbl")
          .css({
            fontWeight: "bold",
            paddingRight: "10px",
            width: "160px", // Fija el ancho de las celdas de los títulos
            wordWrap: "break-word", // Permite que los títulos se dividan en varias líneas si son largos
            whiteSpace: "normal", // Permite el salto de línea en títulos largos
            boxSizing: "border-box",
          })
          .text(capitalizeFirstLetter(label) + ":");

        var valueDiv = $("<td>")
          .addClass("tbl-cell")
          .css({
            flex: "1",
            minWidth: "0",
            width: "150px",
            overflowWrap: "break-word",
            boxSizing: "border-box",
            padding: "2px", // Agrega padding dentro de las celdas
          })
          .text(value);

        row.append(labelDiv).append(valueDiv);

        if (iconId) {
          var icon = $("<i>")
            .addClass("fa fa-clone")
            .attr("id", iconId)
            .css({
              cursor: "pointer",
              marginLeft: "5px",
            })
            .attr("data-copiar-texto", value)
            .on("click", function () {
              var text = $(this).attr("data-copiar-texto");
              navigator.clipboard.writeText(text).then(
                function () {
                  swal({
                    title: "OK",
                    icon: "success",
                    timer: 100,
                    showConfirmButton: false,
                    position: "top-end",
                  });
                },
                function (err) {
                  swal("Ocurrió un error en la solicitud: " + err);
                }
              );
            });

          row.append(icon);
        }

        $("#datosContainer").append(row);
      }

      // Mostrar datos específicos y ocultar si no existen
      if (data[0]["CEDULA"]) {
        createRow("Cédula", data[0]["CEDULA"], "copy-cc");
        $("#cli_cc").val(data[0]["CEDULA"]);
        $("#cli_cc").prop("disabled", true);
      }
      if (data[0]["NOMBRE"]) {
        createRow("Nombre", data[0]["NOMBRE"]);
        $("#cli_nombre").val(data[0]["NOMBRE"]);
        $("#cli_nombre").prop("disabled", true);
      }
      if (tel) {
        var celen = enmascararTelefono(tel);
        createRow("Teléfono", celen);
        $("#cli_telefono").val(celen);
        $("#cli_telefono").prop("disabled", true);
        $("#llamar1").prop("disabled", false);
        $("#llamar1").css("background-color", "");
        $("#llamar1").css("border-color", "");
      } else {
        $("#llamar1").css("background-color", "gray");
        $("#llamar1").css("border-color", "gray");
      }
      if (data[0]["CONVENIO"]) {
        createRow("Convenio", data[0]["CONVENIO"]);

        var existingData = $("#cli_convenio")
          .select2("data")
          .map((item) => item.text);
        if (!existingData.includes(data[0]["CONVENIO"].toUpperCase())) {
          var newOption = new Option(
            data[0]["CONVENIO"].toUpperCase(),
            data[0]["CONVENIO"].toUpperCase()
          );
          $("#cli_convenio").append(newOption).trigger("change");
        }
        $("#cli_convenio")
          .val(data[0]["CONVENIO"].toUpperCase())
          .trigger("change");
      }
      if (tel2) {
        telen = enmascararTelefono(tel2);
        createRow("Otro Teléfono", telen);
        $("#tel_alternativo").val(telen);
        $("#llamar2").prop("disabled", false);
        $("#llamar2").css("background-color", "");
        $("#llamar2").css("border-color", "");
        $("#llamar2").css("color", "");
      } else {
        $("#llamar2").css("background-color", "gray");
        $("#llamar2").css("border-color", "gray");
      }
      if (data[0]["CORREO"]) {
        createRow("Correo", data[0]["CORREO"]);
        $("#cli_mail").val(data[0]["CORREO"]);
      }
      if (data[0]["CIUDAD"]) {
        createRow("Ciudad", data[0]["CIUDAD"]);

        var ciudad = data[0]["CIUDAD"].toUpperCase();

        var existingData = $("#cli_ciudad")
          .select2("data")
          .map((item) => item.text);
        if (!existingData.includes(ciudad)) {
          var newOption = new Option(ciudad, ciudad, false, false);
          $("#cli_ciudad").append(newOption).trigger("change");
        }

        $("#cli_ciudad").val(ciudad).trigger("change");
      }
      if (data[0]["DEPARTAMENTO"]) {
        createRow("Departamento", data[0]["DEPARTAMENTO"]);

        $("#cli_depa").val(data[0]["DEPARTAMENTO"].toUpperCase());
      }

      // Mostrar otros datos dinámicamente
      for (var key in data[0]) {
        if (
          data[0].hasOwnProperty(key) &&
          ![
            "ESTADO",
            "INTENTOS",
            "AGENTE",
            "FECHA",
            "HORA",
            "OBSERVACIONES",
            "id",
            "CEDULA",
            "TELEFONO",
            "TELALTERNATIVO",
            "NOMBRE",
            "CONVENIO",
            "CORREO",
            "CIUDAD",
            "DEPARTAMENTO",
            "FECHAVLL",
          ].includes(key) &&
          isNaN(key)
        ) {
          var value = data[0][key] || "";
          createRow(key, value);
        }
      }

      seccion.disabled = false;
      guardar.disabled = false;
      $(guardar).css("background-color", "");
      $(guardar).css("color", "");
    },
  });
}
function enmascararTelefono(telefono) {
  if (telefono.length <= 4) {
    return telefono;
  }
  var ultimos4 = telefono.slice(-4); // Obtener los últimos 4 dígitos
  var asteriscos = "*".repeat(telefono.length - 4); // Crear la cadena de asteriscos
  return asteriscos + ultimos4; // Combinar y devolver
}
function iniciarCampana() {
console.log("hh")
  $.ajax({
    url: "../../controller/campana.php?op=bcampana",
    type: "POST",
    data: { camp_id: idcam },
    success: function (datos) {
      var data = JSON.parse(datos);
      var fechaFinal = data[0].fFinal;
      intentos = data[0].cam_int;
      var horaInicio = data[0].hora_ini.replace(/:00$/, "");
      var horaFinal = data[0].hora_fin.replace(/:00$/, "");
      var vencimiento = fechaFinal;
      var dhorario = horaInicio + " - " + horaFinal;
      var comentariocampana = data[0].cam_coment;
      nombreTabla = data[0].nombreTabla;
      nombrecampaña = data[0].nombrecamp;
      siguiente.disabled = false;
      $(siguiente).css("background-color", "");
      $(siguiente).css("color", "");

      filtro = $("#filtro").val();
      if (!filtro) {
        var textointentos = intentos;
        if (intentos2 != "") {
          textointentos = intentos + "/" + intentos2;
        }
        console.log(data);
        console.log(nombreTabla);
        $("#vencimiento").text(vencimiento);
        $("#horario").text(dhorario);
        $("#comentarios").text(comentariocampana);
        $("#nombrecam").text(nombrecampaña);
        $("#intentos").text(textointentos);
      } else {
        $("#vencimiento").text("");
        $("#horario").text("");
        $("#intentos").text("");
        $("#comentarios").text(comentariocampana);
      }
    },
  });
}
async function contactos() {
  try {
    const response = await $.ajax({
      url: "../../controller/llamada.php?op=bllamada",
      type: "POST",
      data: { camp_id: idcam },
    });

    const data = JSON.parse(response);
    countID = data[0]["@cantidadSinAgente"];
    $("#contactos").text(countID);

    if (countID === "0") {
      siguiente.disabled = true;
      $(siguiente).css("background-color", "gray");
      $(siguiente).css("color", "white");
      var href = "../listarcampanas/";

      limpiardatos();
      $("#cli_cc").val("");
      $("#cli_nombre").val("");
      $("#cli_telefono").val("");
      $("#cli_convenio").val("");
      $("#cli_edad").val("");
      $("#cli_ciudad").val("");
      $("#tel_alternativo").val("");
      $("#cli_mail").val("");
      $("#com_client").summernote("reset");

      window.location.href = href;
    }
  } catch (error) {
    swal("Ocurrió un error en la solicitud: " + error);
  }
}
function limpiardatos() {
  $("#contactos").text("");
  $("#vencimiento").text("");
  $("#horario").text("");
  $("#comentarios").text("");
  $("#intentos").text("");
  $("#nombre").val("");
  $("#com_client").summernote("code", "");
}
function ciudad() {
  // CIUDAD
  $("#cli_ciudad")
    .select2({
      placeholder: "Escribe una ciudad",
      allowClear: false,
      // tags: true,
      ajax: {
        url: "../../controller/ciudad.php?op=ciudad",
        type: "POST",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            term: params.term.trim().toLowerCase(),
          };
        },
        processResults: function (data) {
          return {
            results: data.map(function (city) {
              return {
                id: city.ciu_nom,
                text: city.ciu_nom,
                department: city.ciu_dep,
              };
            }),
          };
        },
        cache: false,
      },
      minimumInputLength: 3,
    })
    .on("select2:select", function (e) {
      var selectedCity = e.params.data;
      $("#cli_depa").val(selectedCity.department);
    });
}
function convenio() {
  $("#cli_convenio").select2({
    placeholder: "Escriba un convenio",
    allowClear: false,
    tags: true,
    ajax: {
      url: "../../controller/convenio.php?op=convenio",
      type: "POST",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          term: params.term.trim().toLowerCase(),
          identidad: $("#cli_entidad").val(),
        };
      },
      processResults: function (data) {
        return {
          results: data.map(function (convenio) {
            return {
              id: convenio.con_nom,
              text: convenio.con_nom,
            };
          }),
        };
      },
      cache: false,
    },
    minimumInputLength: 3,
  });
}
function entidad() {
  $.post("../../controller/entidad.php?op=comboent", function (data, status) {
    $("#cli_entidad").html(data);
  });
}
function estadoc() {
  var selectElement = document.getElementById("cli_estado");
  // Elimina todas las opciones existentes
  selectElement.innerHTML = "";
  // Añade la opción "Interesado"
  var option = document.createElement("option");
  option.text = "Interesado";
  selectElement.add(option);
}
function toma() {
  var selectElement = document.getElementById("toma-contac");
  // Elimina todas las opciones existentes
  selectElement.innerHTML = "";
  // Añade la opción "Interesado"
  var option = document.createElement("option");
  option.text = "CALL CENTER";
  option.value = 1;
  selectElement.add(option);
}
function agente() {
  if (usuPerfil == "Administrador" || usuPerfil == "Operativo") {
    $.post("../../controller/usuario.php?op=combo_agenteadmin", function (data, status) {
      var valor;
      var options = '<option value="0">NINGUNO</option>';
      options += data;

      $("#cli_agente").html(options);

      if (usu_id && $("#cli_asesor").find('option[value="' + usu_id + '"]').length > 0) {
          // Si usu_id está en las opciones, seleccionarlo
          $("#cli_agente").val(usu_id).trigger('change');
      } else {
          // Si usu_id no está en las opciones o no está definido, seleccionar la primera opción
          $("#cli_agente").prop('selectedIndex', 0).trigger('change');
      }
      
    });
  } else {
    $.post("../../controller/usuario.php?op=usuario", function (data, status) {
      $("#cli_agente").html(data);
    });
  }
}
function asesor() {
  if(usuPerfil == "Administrador" || usuPerfil == "Operativo"){
    $.post("../../controller/usuario.php?op=combo_asesoradmin", function (data, status) {
      $("#cli_asesor").html(data);

      if (usu_id && $("#cli_asesor").find('option[value="' + usu_id + '"]').length > 0) {
          // Si usu_id está en las opciones, seleccionarlo
          $("#cli_asesor").val(usu_id).trigger('change');
      } else {
          // Si usu_id no está en las opciones o no está definido, seleccionar la primera opción
          $("#cli_asesor").prop('selectedIndex', 0).trigger('change');
      }
    });
  } else if (usuPerfil == "Coordinador") {
    if(grupoc != ""){
      $.post("../../controller/usuario.php?op=combogrupogcom", function (data, status) {
        $("#asesor").html(data);
        if (cliente[22]) {
          if ($("#asesor option[value='" + cliente[22] + "']").length === 0) {
            // Si no existe la opción, la añadimos
            $("#asesor").append(new Option(cliente[22], cliente[23]));
          }
          // Seleccionamos la opción
          $("#asesor").val(cliente[22]);
        }
      });
    }else{
      $.post(
        "../../controller/usuario.php?op=usuario",
        function (data, status) {
          $("#cli_asesor").html(data);
        }
      );
    }
  } else if(usuPerfil == "Agente"){
    $.post("../../controller/usuario.php?op=combo_agente", function (data, status) {
      $("#cli_asesor").html(data);
    });
  }else{
    $.post("../../controller/usuario.php?op=usuario", function (data, status) {
      $("#cli_asesor").html(data);
    });
  }
}
$("#tel").on("click", function (e) {
  
  // var url = "https://pbx.byapps.co/fop2/?exten=";//para conekta
  var url = "https://pbx.valorconfianza.com.co/fop2/?exten=";//para vconfianza
  // Abre la URL y guarda la referencia de la ventana
  telWindow = window.open(url + sip_ext + "&pass=" + sip_pass);
  if (telWindow) {
    console.log("Ventana abierta exitosamente");
  } else {
    swal({
      title: "Error",
      text: "No se pudo abrir la ventana. Verifica que el bloqueador de pop-ups esté desactivado.",
      icon: "error",
    });
  }
});
$("#siguiente").on("click", async function () {
  $("#cli_des").val("");
  // Verifica si la ventana sigue abierta
  if (telWindow && !telWindow.closed) {
    // Si la ventana está abierta, continúa con el proceso normal
    await contactos();

    terminar.disabled = true;
    $(terminar).css("background-color", "gray");

    var count = countID;
    if (count === 0) {
      var href = "../listarcampanas/";

      limpiardatos();
      $("#cli_cc").val("");
      $("#cli_nombre").val("");
      $("#cli_telefono").val("");
      $("#cli_convenio").val("");
      $("#cli_edad").val("");
      $("#cli_ciudad").val("");
      $("#tel_alternativo").val("");
      $("#cli_mail").val("");
      $("#com_client").summernote("code", "");

      window.location.href = href;
    } else {
      var formData = new FormData();

      var valores = {
        usu_id: usu_id,
        nombreTabla: nombreTabla,
      };

      for (var key in valores) {
        if (valores.hasOwnProperty(key)) {
          formData.append(key, valores[key]);
        }
      }

      $.ajax({
        url: "../../controller/llamada.php?op=agenteLlamada",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
          // Limpiar campos antes de agregar nuevos datos
          $("#cli_cc").val("");
          $("#cli_nombre").val("");
          $("#cli_telefono").val("");
          $("#cli_convenio").val("");
          $("#cli_edad").val("");
          $("#cli_ciudad").val("").trigger("change");
          $("#cli_depa").val("");
          $("#tel_alternativo").val("");
          $("#cli_mail").val("");

          var data = JSON.parse(datos);

          var intentos2 = data[0].INTENTOS;
          $("#intentos").html(intentos + "/" + intentos2);
          idcli = data[0].id;
          var cc = data[0].CEDULA;
          tel = data[0].TELEFONO;
          tel2 = data[0].TELALTERNATIVO;
          nombre = data[0].NOMBRE;
          conve = data[0].CONVENIO;

          // Campos a excluir
          var excludeFields = [
            "ESTADO",
            "INTENTOS",
            "AGENTE",
            "FECHA",
            "HORA",
            "OBSERVACIONES",
            "id",
            "CEDULA",
            "TELEFONO",
            "TELALTERNATIVO",
            "NOMBRE",
            "CONVENIO",
            "CORREO",
            "CIUDAD",
            "DEPARTAMENTO",
            "FECHAVLL",
          ];

          // Contenedor principal para datos
          $("#datosContainer").empty().css({
            backgroundColor: "#ffffff",
            overflow: "auto", // Permite el desplazamiento si el contenido es grande
            width: "100%",
            boxSizing: "border-box",
            padding: "10px",
            tableLayout: "fixed", // Hace que la tabla ocupe todo el ancho disponible
          });

          // Función para capitalizar la primera letra y convertir el resto a minúsculas
          function capitalizeFirstLetter(str) {
            if (!str) return ""; // Maneja casos donde str es null o vacío
            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
          }

          // Función para crear fila de datos
          function createRow(label, value, iconId) {
            if (value === null || value.trim() === "") {
              return; // No crear la fila si el valor está vacío o es null
            }

            var row = $("<div>").addClass("tbl-row").css({
              display: "flex",
              alignItems: "center",
              marginBottom: "5px",
              padding: "5px",
              boxSizing: "border-box",
              borderBottom: "1px solid #ddd", // Agrega una línea divisoria entre filas
            });

            var labelDiv = $("<div>")
              .addClass("tbl-cell tbl-cell-lbl")
              .css({
                fontWeight: "bold",
                marginRight: "10px",
                minWidth: "150px", // Ajusta el ancho mínimo
                whiteSpace: "nowrap", // Evita que el texto se divida en varias líneas
                overflow: "hidden", // Oculta el desbordamiento del texto
                textOverflow: "ellipsis", // Muestra "..." para texto largo
                boxSizing: "border-box",
              })
              .text(capitalizeFirstLetter(label) + ":");

            var valueDiv = $("<div>")
              .addClass("tbl-cell")
              .css({
                flex: "1",
                boxSizing: "border-box",
                whiteSpace: "nowrap", // Evita que el texto se divida en varias líneas
                overflow: "hidden", // Oculta el desbordamiento del texto
                textOverflow: "ellipsis", // Muestra "..." para texto largo
              })
              .text(value);

            row.append(labelDiv).append(valueDiv);

            if (iconId) {
              var icon = $("<i>")
                .addClass("fa fa-clone")
                .attr("id", iconId)
                .css({
                  display: "inline",
                  marginLeft: "10px",
                  cursor: "pointer",
                })
                .attr("data-copiar-texto", value)
                .on("click", function () {
                  var text = $(this).attr("data-copiar-texto");
                  navigator.clipboard.writeText(text).then(
                    function () {
                      swal({
                        title: "OK",
                        icon: "success",
                        timer: 100,
                        showConfirmButton: false, // Desactiva los botones de la alerta
                        position: "top-end",
                      });
                    },
                    function (err) {
                      swal("Ocurrió un error en la solicitud: " + err);
                    }
                  );
                });

              row.append(icon);
            }

            $("#datosContainer").append(row);
          }

          // Mostrar datos específicos y ocultar si no existen
          if (data[0]["CEDULA"]) {
            createRow("Cédula", data[0]["CEDULA"], "copy-cc");
            $("#cli_cc").val(data[0]["CEDULA"]);
            $("#cli_cc").prop("disabled", true);
          }
          if (data[0]["NOMBRE"]) {
            createRow("Nombre", data[0]["NOMBRE"]);
            $("#cli_nombre").val(data[0]["NOMBRE"]);
            $("#cli_nombre").prop("disabled", true);
          }
          if (tel) {
            var celen = enmascararTelefono(tel);
            createRow("Teléfono", celen);
            $("#cli_telefono").val(celen);
            $("#cli_telefono").prop("disabled", true);
            $("#llamar1").prop("disabled", false);
            $("#llamar1").css("background-color", "");
            $("#llamar1").css("border-color", "");
          } else {
            $("#llamar1").css("background-color", "gray");
            $("#llamar1").css("border-color", "gray");
          }
          if (data[0]["CONVENIO"]) {
            createRow("Convenio", data[0]["CONVENIO"]);

            var existingData = $("#cli_convenio")
              .select2("data")
              .map((item) => item.text);
            if (!existingData.includes(data[0]["CONVENIO"].toUpperCase())) {
              var newOption = new Option(
                data[0]["CONVENIO"].toUpperCase(),
                data[0]["CONVENIO"].toUpperCase()
              );
              $("#cli_convenio").append(newOption).trigger("change");
            }
            $("#cli_convenio")
              .val(data[0]["CONVENIO"].toUpperCase())
              .trigger("change");
          }
          if (tel2) {
            telen = enmascararTelefono(tel2);
            createRow("Otro Teléfono", telen);
            $("#tel_alternativo").val(telen);
            $("#llamar2").prop("disabled", false);
            $("#llamar2").css("background-color", "");
            $("#llamar2").css("border-color", "");
            $("#llamar2").css("color", "");
          } else {
            $("#llamar2").css("background-color", "gray");
            $("#llamar2").css("border-color", "gray");
          }
          if (data[0]["CORREO"]) {
            createRow("Correo", data[0]["CORREO"]);
            $("#cli_mail").val(data[0]["CORREO"]);
          }
          if (data[0]["CIUDAD"]) {
            createRow("Ciudad", data[0]["CIUDAD"]);

            var ciudad = data[0]["CIUDAD"].toUpperCase();

            var existingData = $("#cli_ciudad")
              .select2("data")
              .map((item) => item.text);
            if (!existingData.includes(ciudad)) {
              var newOption = new Option(ciudad, ciudad, false, false);
              $("#cli_ciudad").append(newOption).trigger("change");
            }

            $("#cli_ciudad").val(ciudad).trigger("change");
          }
          if (data[0]["DEPARTAMENTO"]) {
            createRow("Departamento", data[0]["DEPARTAMENTO"]);

            $("#cli_depa").val(data[0]["DEPARTAMENTO"].toUpperCase());
          }

          // Mostrar otros datos dinámicamente
          for (var key in data[0]) {
            if (
              data[0].hasOwnProperty(key) &&
              !excludeFields.includes(key) &&
              isNaN(key)
            ) {
              var value = data[0][key] || "";
              createRow(key, value);
            }
          }

          seccion.disabled = false;
          $("#cli_des").prop("disabled", false);
          $(guardar).css("background-color", "");
          $(guardar).css("color", "");
          guardar.disabled = false;

          noRepetirCCyTel(cc, tel);
        },
      });

      siguiente.disabled = true;
      $(siguiente).css("background-color", "gray");
      $(siguiente).css("color", "white");
    }
  } else {
    // Si la ventana no está abierta, muestra un mensaje de alerta
    swal({
      title: "Atención",
      text: "Debe abrir el teléfono antes de continuar.",
      icon: "warning",
    });
  }
});
function noRepetirCCyTel(c, t) {
  // Inicializar contadores
  let conteotel = 0;
  let conteocc = 0;

   // Crear un array de promesas
   let promises = [];

  // Verificar cédula
  if (c != null && c != "") {
    let promiseCC = $.ajax({
      url: "../../controller/cliente.php?op=noRepetircc",
      type: "POST",
      data: { c: c },
    }).then(function(response) {
      var data = JSON.parse(response);
      conteocc = +data[0]["count(cli_id)"];
    });
    promises.push(promiseCC);
  }
  // Verificar teléfono
  if (t != null && t != "") {
    let promiseTel = $.ajax({
      url: "../../controller/cliente.php?op=noRepetirTel",
      type: "POST",
      data: { t: t },
    }).then(function(response) {
      var data = JSON.parse(response);
      conteotel = +data[0]["count(cli_id)"];
    });
    promises.push(promiseTel);
  }

  // Esperar a que todas las promesas se completen
  Promise.all(promises).then(function() {
    if (conteotel > 0 && conteocc > 0) {
      swal("Error: Esta cédula y este celular ya pertenecen a un cliente. Por favor, valida los datos.");
    } else if (conteotel > 0 && conteocc <= 0) {
      swal("Error: El celular ya pertenece a un cliente, por favor valida los datos.");
    } else if (conteotel <= 0 && conteocc > 0) {
      swal("Error: La cédula ya pertenece a un cliente, por favor valida los datos.");
    }
  }).catch(function(error) {
    // console.error("Error en la solicitud AJAX:", error);
    swal("Error al validar los datos. Por favor, intenta de nuevo.");
  });
}
$("#llamar1").on("click", function () {
  if (telWindow && !telWindow.closed) {
    $.post(
      "../../controller/llamada.php?op=validar_llamada",
      { idcli: idcli, idcam: idcam },
      function (data) {
        var data = JSON.parse(data);
        var resultado = data[0].resultado;

        if (resultado != 0 && resultado != "0") {
          $.post(
            "../../controller/llamada.php?op=llamar",
            {
              number: tel,
              idcli: idcli,
              idcam: idcam,
              sip_pass: sip_pass,
              sip_ext: sip_ext,
            },
            function (data) {
              $("#intentos").text(intentos + "/" + resultado);
            }
          );
        } else {
          // Si ya se cumplio los intentos manda msj
          swal({
            title: "Atención",
            text: "Ya se alcanzaron los intentos de llamada para este registro. No se pueden realizar más llamadas.",
            icon: "warning",
          });
        }
      }
    );
  } else {
    // Si la ventana no está abierta, muestra un mensaje de alerta
    swal({
      title: "Atención",
      text: "Debe abrir el teléfono antes de continuar.",
      icon: "warning",
    });
  }
});
$("#llamar2").on("click", function () {
  if (telWindow && !telWindow.closed) {
    $.post(
      "../../controller/llamada.php?op=validar_llamada",
      { idcli: idcli, idcam: idcam },
      function (data) {
        var data = JSON.parse(data);
        var resultado = data[0].resultado;

        if (resultado != 0 && resultado != "0") {
          $.post(
            "../../controller/llamada.php?op=llamar",
            {
              number: tel2,
              idcli: idcli,
              idcam: idcam,
              sip_pass: sip_pass,
              sip_ext: sip_ext,
            },
            function (data) {
              $("#intentos").text(intentos + "/" + resultado);
            }
          );
        } else {
          // Si ya se cumplio los intentos manda msj
          swal({
            title: "Atención",
            text: "Ya se alcanzaron los intentos de llamada para este registro. No se pueden realizar más llamadas.",
            icon: "warning",
          });
        }
      }
    );
  } else {
    // Si la ventana no está abierta, muestra un mensaje de alerta
    swal({
      title: "Atención",
      text: "Debe abrir el teléfono antes de continuar.",
      icon: "warning",
    });
  }
});
$(document).on("click", "#pausa", function () {
  /* TODO:Mostrar Modal */
  $("#modalpausa").modal("show");
});
$("#pausa_form").on("submit", function (e) {
  e.preventDefault();
  motivo = $("#mot_pau").val();
  var estado = 1;
  $("#modalpausa").modal("hide");
  // Mostrar el overlay
  $("#overlay").show();
  pausaEnCurso = true;

  $.post(
    "../../controller/reconsola.php?op=registrar",
    { campid: idcam, detalle: motivo, estado: estado },
    function (data, status) {}
  );
  // Iniciar el temporizador para la acción periódica
  iniciarTemporizador();
});
// Función para despausar y ocultar el overlay
function quitarPausa() {
  $.post(
    "../../controller/reconsola.php?op=registrar",
    { campid: idcam, detalle: motivo, estado: 2 },
    function (data, status) {}
  );
  $("#overlay").hide();
  pausaEnCurso = false;

  // Detener el temporizador cuando se quite la pausa
  detenerTemporizador();
}
// Función para la acción periódica
function accionPeriodica() {
  document.dispatchEvent(new Event("mousemove"));
}
// Iniciar el temporizador para ejecutar la acción periódica cada 5 minutos
function iniciarTemporizador() {
  if (!intervaloPausa) {
    intervaloPausa = setInterval(function () {
      if (pausaEnCurso) {
        accionPeriodica();
      }
    }, 300000); // 300000 ms = 5 minutos
  }
}
// Detener el temporizador
function detenerTemporizador() {
  if (intervaloPausa) {
    clearInterval(intervaloPausa);
    intervaloPausa = null;
  }
}
$("#terminar").on("click", function () {
  var text = $("#terminar").text();
  if (text === "Volver") {
    var detalle = "AGENDA";
    var estado = 2;
    $.post(
      "../../controller/reconsola.php?op=registrar",
      { campid: idcam, detalle: detalle, estado: estado },
      function (data, status) {
        //volver a la pestaña anterior
        window.history.back();
      }
    );
  } else {
    var detalle = "CONSOLA";
    var estado = 2;
    $.post(
      "../../controller/reconsola.php?op=registrar",
      { campid: idcam, detalle: detalle, estado: estado },
      function (data, status) {
        var href = "../listarcampanas/";
        limpiardatos();
        window.location.href = href;
      }
    );
  }
});
$("#cli_entidad").on("change", function () {
  var entidad = $(this).val();
});
$("#est_laboral").on("change", function () {
  var estado = $("#est_laboral").val();
  if (estado == "ACTIVO") {
    $("#tipo_contrato").prop("disabled", false);
    $("#cli_cargo").prop("disabled", false);
    $("#tipo_pension").prop("disabled", true);
  } else if (estado == "PENSIONADO") {
    $("#tipo_contrato").prop("disabled", true);
    $("#cli_cargo").prop("disabled", true);
    $("#tipo_pension").prop("disabled", false);
  } else {
    $("#tipo_contrato").prop("disabled", false);
    $("#cli_cargo").prop("disabled", false);
    $("#tipo_pension").prop("disabled", false);
  }
});
$("#Guardar").on("click", function () {
  seleccion = $(seccion).val();
  estado = $("#seleccion option:selected").text();
  observaciones = $("#cli_des").val();
  agenda = $("#cli_agenda").val();
  hora = $("#cli_hora").val();

  if (seleccion === "" || seleccion === "seccion0") {
    swal({
      title: "Error",
      text: "Selecciona una opcion valida.",
      type: "error",
      confirmButtonClass: "btn-danger",
    });
  }
  // otros
  else if (seleccion === "seccion1") {
    if (observaciones == "" || observaciones == undefined) {
      swal({
        title: "Error",
        text: "Escribe una observacion.",
        type: "error",
        confirmButtonClass: "btn-danger",
      });
    } else {
      guardarsecc();
    }
  }
  // volver a llamar
  else if (seleccion === "seccion2") {
    if (
      (observaciones == "" || observaciones == undefined) &&
      (agenda == "" || agenda == undefined)
    ) {
      hora = "";
      swal({
        title: "Error",
        text: "Por favor, complete los datos de la llamada.",
        type: "error",
        confirmButtonClass: "btn-danger",
      });
    } else {
      estado = "Volver a llamar";
      observaciones = $("#cli_des2").val();

      guardarsecc();
    }
  }
  // crear cliente
  else if (seleccion === "seccion3") {
    if (
      $("#cli_ciudad").val() != "" &&
      $("#cli_ciudad").val() != null &&
      $("#cli_convenio").val() != "" &&
      $("#cli_convenio").val() != null
    ) {
      Interesado();
    } else {
      swal({
        title: "BYAPPS::CRM",
        text: "Por favor selecciona una ciudad o un convenio.",
        type: "warning",
        confirmButtonClass: "btn-warning",
      });
    }
  } else {
    swal({
      title: "Error",
      text: "No haz seleccionado una opcion valida.",
      type: "error",
      confirmButtonClass: "btn-danger",
    });
  }
});
function guardarsecc() {
  $.post(
    "../../controller/llamada.php?op=guardarsec",
    {
      observaciones: observaciones,
      estado: estado,
      tabla: nombreTabla,
      agenda: agenda,
      id: idcli,
      hora: hora,
      nombre: nombre,
      nombrecampaña: nombrecampaña,
      idcam: idcam,
      conve: conve,
    },
    function (data) {
      var response = JSON.parse(data);

      if (response["Result"] === "1" || response["Result"] === 1) {
        // Mostrar mensaje de éxito
        swal("Exito al registrar datos.");
        $("#cli_des").val();
        $("#cli_agenda").val();
        $("#llamar1").prop("disabled", true);
        $("#llamar1").css("background-color", "gray");
        $("#llamar1").css("border-color", "gray");
        $("#llamar2").prop("disabled", true);
        $("#llamar2").css("background-color", "gray");
        $("#llamar2").css("border-color", "gray");
        $("#cli_des").prop("disabled", true);
        terminar.disabled = false;
        $(terminar).css("background-color", "");
        guardar.disabled = true;
        $(guardar).css("background-color", "gray");

        if (filtro == false) {
          siguiente.disabled = false;
          $(siguiente).css("background-color", "");
          $(siguiente).css("color", "");
        }

        seccion.disabled = true;
        $("#seleccion").val("seccion0").trigger("change");
        $("#seleccion").prop("disabled", true);
        $("#cli_des").val("");
        $("#cli_des2").val("");
        $("#cli_agenda").val("");
      } else {
        // Mostrar mensaje de error
        swal("Error", data, "error");
      }
    }
  );
}
function Interesado() {
  observaciones = "";
  estado = "Interesado";
  agenda = "";
  guardarCliente();
}
function guardarCliente() {
  var formData = new FormData($("#cliente_form")[0]);
  formData.append("cli_telefono", tel);
  formData.append("cli_cc", $("#cli_cc").val());
  formData.append("cli_nombre", $("#cli_nombre").val());
  formData.append("cli_telefono", tel);
  formData.append("cli_asesor", $("#cli_asesor").val());
  formData.append("comentario", $("#com_client").summernote("code"));
  formData.append("tabla", nombreTabla);
  formData.append("idcli", idcli);
  formData.append("idcam", idcam);
  formData.append("observaciones", observaciones);
  formData.append("estado", estado);  

  if ($("#tel_alternativo").val() == telen) {
    formData.append("tel_alternativo", tel2);
  } else {
    formData.append("tel_alternativo", $("#tel_alternativo").val());
  }

  observaciones = "Cliente creado";

  $.ajax({
    url: "../../controller/cliente.php?op=insert",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      var response = JSON.parse(response);

      if (response) {
        // Mostrar mensaje de éxito
        swal("Éxito al registrar datos.");
        $("#cli_des").val("");
        $("#cli_agenda").val("");
        $("#com_client").summernote("code", "");
        guardar.disabled = true;
        $(guardar).css("background-color", "gray");
        seleccion.disabled = true;
        siguiente.disabled = false;
        $(siguiente).css("background-color", "");
        $(siguiente).css("color", "");
        terminar.disabled = false;
        $(terminar).css("background-color", "");
        $("#seleccion").val("seccion0").trigger("change");
        $("#seleccion").prop("disabled", true);
        $("#cli_des").val("");
        $("#cli_des2").val(""); 
        $("#cli_agenda").val("");
      } else {
        // Mostrar mensaje de error
        swal("Error", response.message, "error");
      }
    },
  });
}
$("#com_client").summernote({
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
  callbacks: {
    onPaste: function(e) {
        e.preventDefault(); // Evitar el comportamiento por defecto
        var clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
        var pastedData = clipboardData.getData('Text'); // Obtener solo el texto plano

        // Insertar el texto plano en el editor
        document.execCommand('insertText', false, pastedData);
    }
}
});

init();