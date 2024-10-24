var num = 1;
var filtro = true;

function init() {
  document.getElementById("cliente_form").reset();
  if (form == "cc") {
    $("#titulo").text("Crear Cliente");
  } else {
    $("#titulo").text("Crear Consulta");
  }
}
$(document).ready(function () {
  // CIUDAD
  $("#cli_ciudad")
    .select2({
      placeholder: "Escribe una ciudad",
      allowClear: false,
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

  // ENTIDAD
  entidad();
 
  listarasesor();
  listaragente();

  //TOMA CONTACTO
  $.post("../../controller/cliente.php?op=combo", function (data, status) {
    $("#toma-contac").html(data);
    campostomacontacto();
  });
});
function listarasesor() {
  if(usuPerfil == "Administrador" || usuPerfil == "Operativo"){
    $.post("../../controller/usuario.php?op=combo_asesoradmin", function (data, status) {
      // console.log(data);
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
  } else {
    $.post("../../controller/usuario.php?op=usuario", function (data, status) {
          $("#cli_asesor").html(data);
        });
  }
}
function listaragente() {
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
    // console.log(usuPerfil)

    if(usuPerfil == "Asesor"){
      var options = '<option value="0">NINGUNO</option>';
        $("#cli_agente").html(options);
    }else{
      $.post("../../controller/usuario.php?op=usuario", function (data, status) {
        // console.log(data);
        var options = '<option value="0">NINGUNO</option>';
        options += data;
        $("#cli_agente").html(options);
      });
    }
    
  }
}
$("#cli_entidad").on("change", function () {
  var entidad = $(this).val();
  if (entidad) {
    $("#cli_convenio").val(null).trigger("change"); // Limpiar convenios al cambiar entidad
  }
});
function entidad() {
  $.post("../../controller/entidad.php?op=comboent", function (data, status) {
    $("#cli_entidad").html(data);
    configurarSelect2Convenios();
  });
}
function configurarSelect2Convenios() {
  $("#cli_convenio").select2({
    placeholder: "Escriba un convenio",
    allowClear: false,
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
function campostomacontacto() {
  const tomacontacto = document.getElementById("toma-contac");
}
// Activar y desactivar campos segun estado
document.addEventListener("DOMContentLoaded", function () {
  //datos para cmbio de estado laboral
  const estLaboral = document.getElementById("est_laboral");
  const tcontrato = document.getElementById("tipo_contrato");
  const cargo = document.getElementById("cli_cargo");
  const tservicio = document.getElementById("tiem_servicio");
  const tpension = document.getElementById("tipo_pension");
  //datos para tomacontacto
  const tomacontacto = document.getElementById("toma-contac");

  estLaboral.addEventListener("change", function () {
    const value = estLaboral.value;
    if (value === "ACTIVO") {
      tcontrato.disabled = false;
      cargo.disabled = false;
      tservicio.disabled = false;
      tpension.disabled = true;
    } else if (value === "PENSIONADO") {
      tcontrato.disabled = true;
      cargo.disabled = true;
      tservicio.disabled = false;
      tpension.disabled = false;
    } else if (value === "PENSIONADO/ACTIVO") {
      tcontrato.disabled = false;
      cargo.disabled = false;
      tservicio.disabled = false;
      tpension.disabled = false;
    } else {
      tcontrato.disabled = true;
      cargo.disabled = true;
      tservicio.disabled = true;
      tpension.disabled = true;
    }
  });
  tomacontacto.addEventListener("change", function () {
    campostomacontacto();
  });
});
$("#cliente_form").on("submit", function (e) {
  e.preventDefault();
  noRepetirCCyTel();
});
function noRepetirCCyTel() {
  var c = $("#cli_cc").val();
  var t = $("#cli_telefono").val();

  // Verificación de la cédula
  $.ajax({
    url: "../../controller/cliente.php?op=noRepetircc",
    type: "POST",
    data: { c: c },
    success: function (response) {
      var data = JSON.parse(response);
      var conteocc = +data[0]["count(cli_id)"];

      if (conteocc > 0) {
        swal(
          "Error: Cedula ya pertenece a un Cliente, por favor valida los datos."
        );
      } else {
        noRepetirTel(t);
      }
    },
  });
}
function noRepetirTel(t) {
  $.ajax({
    url: "../../controller/cliente.php?op=noRepetirTel",
    type: "POST",
    data: { t: t },
    success: function (response) {
      var data = JSON.parse(response);
      var conteotel = +data[0]["count(cli_id)"];
      if (conteotel > 0) {
        swal(
          "Error: Telefono ya pertenece a un Cliente, por favor valida los datos."
        );
      } else {
        if (form == "cc") {
          guardarCliente();
        } else {
          crearclientepreselecta();
        }
      }
    },
  });
}
function guardarCliente() {
  var formData = new FormData($("#cliente_form")[0]);
  var tipo = "Comercial";
  var detalle = "Crear cliente";

  // Bloquear el botón de envío y mostrar el símbolo de carga
  var $guardarBtn = $("#crear");
  $guardarBtn.prop("disabled", true);
  $guardarBtn.html('<i class="fa fa-spinner fa-spin"></i> Guardando...');

  $.ajax({
    url: "../../controller/cliente.php?op=insertclienteform",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      // console.log(response);
      if (response.length > 0 && typeof response !== "undefined") {
        $.ajax({
          url: "../../controller/cliente.php?op=logs",
          type: "POST",
          data: JSON.stringify({
            usu_id: usu_id,
            tipo: tipo,
            detalle: detalle,
          }),
          contentType: "application/json",
          processData: false,
          success: function (response) {},
        });
        traerId(response);
      } else {
        swal("Error", data.message, "error");
      }
    },
  });
}
function traerId(data) {
  var documento = $("#cli_cc").val();
  $("#cli_cc").val("");
  $("#cli_nombre").val("");
  $("#cli_edad").val("");
  $("#cli_telefono").val("");
  $("#tel_alternativo").val("");
  $("#cli_mail").val("");
  $("#cli_ciudad").val("");
  $("#cli_entidad").val(1);
  $("#cli_convenio").val("");
  $("#cli_cargo").val("");
  $("#tiem_servicio").val("");
  

  var queryParams = `?i=${data}`;
  var href = "../detallecliente/" + queryParams;

  window.location.href = href;
}

//********* PRESELECTA */
$(document).on("change", ".check-toggle", function () {
  let num = $(this).data("num");
  let isChecked = $(this).prop("checked");
  let estado = isChecked ? 2 : 1;
  let nomestado = estado === 1 ? "No" : "Si";

  // Busca el label asociado al checkbox
  let label = $(this).siblings("label");
  // Si el label existe, actualiza su texto
  if (label.length > 0) {
    label.text(nomestado);
  } else {
    // Si no existe, crea un nuevo elemento label y agrégalo después del checkbox
    label = $("<label>").text(nomestado);
    $(this).after(label);
  }
});
//tipo de credito
$(document).on("change", "#tipocre", function () {
  var tipocredit = $("#tipocre").val();

  if (tipocredit == "COMPRA DE CARTERA") {
    // Mostrar la tabla
    $("#incrementableTable").show();
    filtro = true;
  } else {
    // Ocultar la tabla
    $("#incrementableTable").hide();
    filtro = false;
  }

  // incrementableTable
});
// ADICIONAR FILA
$(document).on("click", ".addRowButton", function () {
  num += 1;

  // Eliminar el botón + de la fila anterior (opcional, si solo quieres que aparezca en la última fila)
  $(this).remove();

  // Crear nueva fila
  var newRow = `<tr>
      <td contenteditable="false">
        <input type="text" oninput="this.value = this.value.toUpperCase()" style="border: none; outline: none; width: 100%; background-color: transparent;" id="entidad${num}">
      </td> 
      <td class="editable-cell" contenteditable="false">
        <input type="text" maxlength="3" oninput="this.value = this.value.replace(/\D/g,'').substring(0, 3)" style="border: none; outline: none; width: 100%; background-color: transparent;" id="plazo${num}">
      </td> 
      <td class="editable-cell" contenteditable="false">
        <input type="text" maxlength="4" oninput="this.value = formatTasa(this.value)" style="border: none; outline: none; width: 100%; background-color: transparent;" id="tasa${num}">
      </td>
      <td class="editable-cell" contenteditable="false">
        <input type="text" oninput="this.value = formatValor(this.value)" maxlength="12" style="background-color: white; border: none; outline: none;" id="cuota${num}">
      </td>
      <td class="checkbox-toggle">
        <input type="checkbox" class="check-toggle" data-num="${num}" id="check${num}">
        <label for="check${num}">No</label>
      </td>
      <td style="width: 70px; text-align: center;">
        <button class="btn btn-danger-outline removeRowButton" style="font-size: 10px; border: none; margin-bottom: 8px;"><i class="fa fa-minus"></i></button>
        <button class="btn btn-primary-outline addRowButton" style="font-size: 10px; border: none; margin-bottom: 8px;"><i class="fa fa-plus"></i></button>
      </td>
    </tr>`;

  // Agregar la nueva fila después de la última fila en el tbody
  $("#incrementableTable tbody").append(newRow);
});
function formatTasa(value) {
  // Eliminar todos los caracteres que no sean dígitos
  value = value.replace(/\D/g, "");

  // Si hay más de un dígito, inserta el punto decimal
  if (value.length > 1) {
    value = value.slice(0, -2) + "." + value.slice(-2);
  }

  // Limitar a 4 caracteres (para mantener la precisión de 2 dígitos después del punto)
  return value.slice(0, 4);
}
function formatValor(value) {
  // Eliminar todos los caracteres que no sean dígitos
  value = value.replace(/\D/g, "");

  // Limitar a 12 caracteres
  value = value.substring(0, 12);

  // Formatear el valor con separadores de miles y agregar $
  if (value.length > 0) {
    value = "$" + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  return value;
}
// REMOVER FILA
$(document).on("click", ".removeRowButton", function () {
  num -= 1;
  var currentRow = $(this).closest("tr");
  var previousRow = currentRow.prev("tr");

  // Remove the current row
  currentRow.remove();

  // If there is no addRowButton in the last row, add it
  if (
    $("#incrementableTable tbody tr").length > 0 &&
    $("#incrementableTable tbody tr").last().find(".addRowButton").length ===
      0 &&
    previousRow.length > 0
  ) {
    previousRow
      .find("td:last")
      .append(
        '<button class="btn btn-primary-outline addRowButton" style="font-size: 10px; border: none; margin-bottom: 8px;"><i class="fa fa-plus"></i></button>'
      );
  }
});
function crearclientepreselecta() {
  var formData = "";
  formData = new FormData($("#cliente_form")[0]);
  formData.append("cli_dir", $("#cli_dir").val());
  formData.append("cli_estado", "Consulta");
  var tipo = "Comercial";
  var detalle = "Crear consulta";
  var comentario = "";

  if (filtro == true) {
    for (let i = 1; i <= num; i++) {
      let entidad = $(`#entidad${i}`).html();
      let plazo = $(`#plazo${i}`).val();
      let tasa = $(`#tasa${i}`).val();
      let cuota = $(`#cuota${i}`).val();
      let desp = $(`#check${i}`).prop("checked");

      // if (!(entidad && plazo && tasa && cuota)) {
      //   // Si alguno de los campos está vacío
      //   swal("Por favor, completa todos los campos para la entidad " + i + ".");
      //   return;
      // }

      comentario +=
        "<strong>Compra de Cartera:</strong> " +
        entidad +
        " <strong>Plazo:</strong> " +
        plazo +
        " <strong>Tasa:</strong> " +
        tasa +
        " <strong>Valor:</strong> " +
        cuota +
        " <strong>Desp:</strong> " +
        (desp ? "<strong>Sí</strong>" : "<strong>No</strong>") +
        "<br>";
    }
  }

  var estcivil = $("#estado_civil").val();
  var percargo = $("#per_acargo").val();
  var ingradic = $("#ing_adici").val();
  var oringresos = $("#ori_ingres").val();
  var tipcre = $("#tipocre").val();
  var valcre = $("#val_credit").val();
  var taspla = $("#tasa_plazo").val();

  var encabezado =
    "<strong>Solicitud Consulta</strong> <br> <strong>Información Adicional </strong> <br> Estado Civil: " +
    estcivil +
    "<br> Personas a cargo: " +
    percargo +
    "<br> Ingresos adicionales: " +
    ingradic +
    "<br> Origen de ingresos: " +
    oringresos +
    "<br> Tipo de credito: " +
    tipcre +
    "<br> Valor de credito: " +
    valcre +
    "<br> Tasa/Plazo: " +
    taspla +
    "<br>";

  comentario = encabezado + comentario;

  if ($("#cedula")[0].files.length === 0) {
    swal("Por favor, sube el soporte antes de guardar.");
    return;
  }
  // if ($("#desprendible")[0].files.length === 0) {
  //   swal("Por favor, sube el AyudaVenta antes de guardar.");
  //   return;
  // }
  if ($("#autorizacion")[0].files.length === 0) {
    swal("Por favor, sube la autorizacion de consulta antes de guardar.");
    return;
  }

  formData.append("comentario", comentario);

  // Bloquear el botón de envío y mostrar el símbolo de carga
  var $guardarBtn = $("#crearc");
  $guardarBtn.prop("disabled", true);
  $guardarBtn.html('<i class="fa fa-spinner fa-spin"></i> Guardando...');

  $.ajax({
    url: "../../controller/cliente.php?op=insertpreselecta",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      // console.log(response);
      if (response != 0) {
        $.ajax({
          url: "../../controller/cliente.php?op=logs",
          type: "POST",
          data: JSON.stringify({
            usu_id: usu_id,
            tipo: tipo,
            detalle: detalle,
          }),
          contentType: "application/json",
          processData: false,
          success: function (res) {},
        });
        var queryParams = `?i=${response}`;
        var href = "../detallecliente/" + queryParams;
        window.location.href = href;
      } else {
        swal("Error", data.message, "error");
      }
      // Desbloquear el botón de envío y restaurar el texto original
      $guardarBtn.prop("disabled", false);
      $guardarBtn.html("Crear Consulta");
    },
  });
}

//**********CONFIGURACION */
$("#cedula").on("change", function () {
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
$("#desprendible").on("change", function () {
  var fileInput = $(this);
  var files = fileInput[0].files;
  var baseTimePerMB = 1000; // Tiempo base en milisegundos por MB

  if (files.length > 0) {
    // Limpiar iconos previos y mostrar el círculo de carga
    $("#fileIcons2").empty();
    $("#loadingCircle2").show();

    var totalSize = 0;
    for (var i = 0; i < files.length; i++) {
      totalSize += files[i].size;
    }
    var totalSizeMB = totalSize / (1024 * 1024);
    var estimatedTime = Math.max(totalSizeMB * baseTimePerMB, 2000); // Tiempo mínimo de 2000ms

    // Simular una carga de archivo
    setTimeout(function () {
      $("#loadingCircle2").hide();

      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var fileIcon =
          '<img src="../../public/img/faq-3.png" style="width: 40px;height: 40px;margin-top: 10px;" alt="' +
          file.name +
          '">';
        $("#fileIcons2").append(fileIcon);
      }
    }, estimatedTime);
  }
});
$("#autorizacion").on("change", function () {
  var fileInput = $(this);
  var files = fileInput[0].files;
  var baseTimePerMB = 1000; // Tiempo base en milisegundos por MB

  if (files.length > 0) {
    // Limpiar iconos previos y mostrar el círculo de carga
    $("#fileIcons3").empty();
    $("#loadingCircle3").show();

    var totalSize = 0;
    for (var i = 0; i < files.length; i++) {
      totalSize += files[i].size;
    }
    var totalSizeMB = totalSize / (1024 * 1024);
    var estimatedTime = Math.max(totalSizeMB * baseTimePerMB, 2000); // Tiempo mínimo de 2000ms

    // Simular una carga de archivo
    setTimeout(function () {
      $("#loadingCircle3").hide();

      for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var fileIcon =
          '<img src="../../public/img/faq-3.png" style="width: 40px;height: 40px;margin-top: 10px;" alt="' +
          file.name +
          '">';
        $("#fileIcons3").append(fileIcon);
      }
    }, estimatedTime);
  }
});

init();
