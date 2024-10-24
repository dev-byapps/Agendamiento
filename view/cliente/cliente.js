var id;
var idcom;
var con_id;
var idcat;
var label;
var estado;
var cliente;
var estadoCRM;
var sip_cuenta;
var sip_ext;
var sip_pass;
var telefono;
var telalter;
var categorias;
var estadoinicio;
var nombre;
var offset = 0;
var limit = 10;
var inicio = true;

function init() {
  const url = window.location.href;
  const params = new URLSearchParams(new URL(url).search);
  const tick_id = params.get("i");
  const decoded_id = decodeURIComponent(tick_id);
  id = decoded_id.replace(/\s/g, "+");

  buscarcliente();
  listaroperaciones();
  mostrarcomentarios();
  listarcategorias();
  listarTareas();
}

/* DATOS DEL CLIENTE*/
function buscarcliente() {
  // console.log(id);

  return new Promise(function (resolve, reject) {
    $.post(
      "../../controller/cliente.php?op=Buscarclienteid",
      { id: id },
      function (data, status) {
        // console.log(data);
        var datos = JSON.parse(data);

        var now = new Date();
        cliente = datos.aaData[0];
        // DATOS DE CLIENTE
        $("#Identificacion").text(cliente[0] + ": " + cliente[1]);
        nombre = cliente[2];
        $("#Nombre").text(cliente[2].toUpperCase());
        $("#Convenio").text(cliente[13].toUpperCase());
        $("#Estado").text(cliente[12].toUpperCase());
        estado = cliente[12].toUpperCase();
        if (cliente[23] != "" && cliente[23] != null) {
          $("#Asesor").text(cliente[23]);
        }
        $("#FeCreacion").text("Fecha Creación: " + cliente[26]);
        $("#FeActualizacion").text("Fecha Actualización: " + cliente[27]);

        //MAS INFORMACIÓN
        $("#tipo_doc").val(cliente[0]);
        $("#cli_cc").val(cliente[1]);
        $("#cli_nombre").val(cliente[2].toUpperCase());
        $("#fec_nac").val(cliente[3]);

        /* EDAD */
        // Convertir la fecha a un objeto Date
        if(cliente[4] != "" || cliente[4] != null){
          var fechaNacimiento = new Date(cliente[4]);
          // Calcular la diferencia en milisegundos
          var diferencia = now - fechaNacimiento;
          // Convertir la diferencia de milisegundos a años
          var edad = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365.25)); // 365.25 para considerar los años bisiestos
          $("#cli_edad").val(edad);
        }else{
          $("#cli_edad").val("0");       }
        

        $("#cli_telefono").val(cliente[5]);
        telefono = cliente[5];
        if (telefono != "" && telefono != null) {
          $("#tel").removeClass("disabled");
        }
        $("#tel_alternativo").val(cliente[6]);
        telalter = cliente[6];
        if (telalter != "" && telalter != null) {
          $("#telalter").removeClass("disabled");
        }
        $("#cli_mail").val(cliente[7]);
        $("#cli_dir").val(cliente[25]);

        // Ciudad
        var newCiudad = new Option(cliente[8], cliente[8], true, true);
        $("#cli_ciudad").append(newCiudad);

        $("#cli_dep").val(cliente[9]);

        // Entidad
        $("#cli_entidad").append(
          $("<option></option>").val(cliente[10]).text(cliente[11])
        );

        // Convenio
        var newConvenio = new Option(cliente[13], cliente[13], true, true);
        $("#cli_convenio").append(newConvenio);
        $("#cli_convenio").val(cliente[13]).trigger("change");

        //Estado Laboral
        var option = $("<option></option>").val(cliente[14]).text(cliente[14]);
        $("#est_laboral").append(option);
        $("#est_laboral").val(cliente[14]).trigger("change");

        $("#tipo_contrato").val(cliente[15]);
        $("#tipo_contrato").prop("disabled", true);

        $("#cli_cargo").val(cliente[16]);
        $("#cli_cargo").prop("readonly", true);

        $("#tiem_servicio").val(cliente[18]);
        $("#tiem_servicio").prop("readonly", true);

        $("#tipo_pension").val(cliente[17]);
        $("#tipo_pension").prop("disabled", true);

        // TOMA CONTACTO
        $option = $("<option></option>").val(cliente[19]).text(cliente[20]);
        $("#contacto").append($option);
        $("#contacto").val(cliente[19]).trigger("change");

        // AGENTE
        if (cliente[21] != "" && cliente[21] != null) {
          var $option = $("<option></option>")
            .val(cliente[21])
            .text(cliente[24]);
          $("#agente").append($option);
          $("#agente").val(cliente[21]).trigger("change");
        } else {
          var $option = $("<option></option>").val("0").text("NINGUNO");
          $("#agente").append($option);
          $("#agente").val("0").trigger("change");
        }

        // ASESOR
        if (cliente[23] != "" && cliente[23] != null) {
          $option = $("<option></option>").val(cliente[22]).text(cliente[23]);
          $("#asesor").append($option);
          $("#asesor").val(cliente[22]).trigger("change");
        } else {
          $("#asesor").val(-1).trigger("change");
        }

        permisos_estado();
      }
    );
  });
}
function permisos_estado() {
  if (estado == "OPERACION") {
    $("#NuevaOperacion").prop("disabled", false);
    $("#editar").prop("disabled", false);
  } else {
    $("#editar").prop("disabled", false);
    $("#NuevaOperacion").prop("disabled", true);
  }

  if (usuPerfil == "Asesor" || usuPerfil == "Coordinador") {
    if (estado == "CONSULTA") {
      $("#resconsult").hide();
    }

    if (
      estado == "INTERESADO" ||
      estado == "ANALISIS" ||
      estado == "CONSULTA" ||
      estado == "VIABLE" ||
      estado == "OFERTA"
    ) {
      $("#btns").show();
      $("#editar").prop("disabled", false);
      $("#mas").prop("disabled", false);
    } else if (
      estado == "OPERACION" ||
      estado == "NO VIABLE" ||
      estado == "NO INTERESADO" ||
      estado == "CERRADO"
    ) {
      $("#btns").hide();
    } else {
      $("#btns").show();

      $("#editar").prop("disabled", true);
      $("#mas").prop("disabled", false);
    }
  } else {
    if (estado == "CONSULTA") {
      $("#resconsult").show();
    }

    $("#btns").show();
    $("#editar").prop("disabled", false);
    $("#mas").prop("disabled", false);
  }
}
$("#dato .dropdown-item").on("click", function (e) {
  e.preventDefault();
  selectedValue = $(this).data("value");
  $("#Estado").text(selectedValue);
  editarestado();
  buscarcliente();
});
function editarestado() {
  $.post(
    "../../controller/cliente.php?op=edestado",
    { id_cli: id, selectedValue: selectedValue },
    function (data, status) {
      swal("Correcto!", "Estado editado correctamente ", "success");
    }
  );
}

/*whatsapp */
function handleClick(tel) {
  if (tel == "tel1") {
    // console.log("tel1: " + telefono);
    var url = "https://api.whatsapp.com/send?phone=57" + telefono;
    window.open(url);
  } else if (tel == "tel2") {
    // console.log("telefono 2: " + telalter);
    var url = "https://api.whatsapp.com/send?phone=57" + telalter;

    window.open(url);
  }
}

/*MAS INFORMACION*/
$("#editar").on("click", function (e) {
  e.preventDefault();

  if ($("#editar").text() == "Editar") {
    listarasesor();
    listaragente();
    listarentidades();
    habilitar();
    $("#editar").text("Cancelar");
    $("#guardar").removeAttr("disabled");
  } else {
    // cargardatos();
    desabilitar();
    $("#editar").text("Editar");
    $("#guardar").prop("disabled", true);
  }
});
function listarasesor() {
  if(usuPerfil == "Administrador" || usuPerfil == "Operativo"){
    $.post("../../controller/usuario.php?op=combo_asesoradmin", function (data, status) {
      var valor;
      var options = '<option value="0">NINGUNO</option>';
      options += data;
      if ($("#asesor").val() != null && $("#asesor").val() != "") {
        $("#asesor").html(data);
      } else {
        $("#asesor").html(data);
        // $("#asesor").val(-1);
      }

      if (cliente[22]) {
        if ($("#asesor option[value='" + cliente[22] + "']").length === 0) {
          // Si no existe la opción, la añadimos
          $("#asesor").append(new Option(cliente[22], cliente[23]));
        }
        // Seleccionamos la opción
        $("#asesor").val(cliente[22]);
      }
    });
  } else if (usuPerfil == "Coordinador") {
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
  } else {
      if (cliente[22]) {
        if ($("#asesor option[value='" + cliente[22] + "']").length === 0) {
          // Si no existe la opción, la añadimos
          $("#asesor").append(new Option(cliente[22], cliente[23]));
        }
        // Seleccionamos la opción
        $("#asesor").val(cliente[22]);
      }
  }
}
function listaragente() {
  if (usuPerfil == "Administrador" || usuPerfil == "Operativo") {
    $.post("../../controller/usuario.php?op=combo_agenteadmin", function (data, status) {
      var valor;
      var options = '<option value="0">NINGUNO</option>';
      options += data;

        $("#agente").html(options);

      if (cliente[21] == null || cliente[21] == "") {
        valor = 0;
      } else {
        valor = cliente[21];
      }

      if (valor) {
        if ($("#agente option[value='" + cliente[21] + "']").length === 0) {
          // Si no existe la opción, la añadimos
          $("#agente").append(new Option(cliente[24], cliente[21]));
          // console.log($("#agente option[value='" + cliente[21] + "']").length);
        }
        // Seleccionamos la opción
        $("#agente").val(cliente[21]);
      }
    });
  } else {
    if (cliente[21]) {
      if ($("#agente option[value='" + cliente[21] + "']").length === 0) {
        // Si no existe la opción, la añadimos
        if (cliente[21] == "" || cliente[21] == null) {
          $("#agente").append(new Option(valor, "NINGUNO"));
        } else {
          $("#agente").append(new Option(cliente[21], cliente[24]));
        }
      }
      // Seleccionamos la opción
      $("#agente").val(cliente[21]);
    }
  }
}
function listarentidades() {
  $.post("../../controller/entidad.php?op=comboent", function (data, status) {
    $("#cli_entidad").html(data);
    if (cliente[10]) {
      $("#cli_entidad").val(cliente[10]);
    }
  });
}
function habilitar() {
  if (usuPerfil != "Asesor" && usuPerfil != "Coordinador") {
    $("#tipo_doc").removeAttr("disabled");
    $("#cli_cc").prop("readonly", false);
    $("#cli_nombre").prop("readonly", false);
    $("#cli_telefono").prop("readonly", false);
  }
  if (usuPerfil == "Asesor") {
    $("#agente").prop("disabled", true);
    $("#asesor").prop("disabled", true);
  } else {
    $("#agente").removeAttr("disabled");
    $("#asesor").removeAttr("disabled");
  }
  $("#fec_nac").prop("readonly", false);
  $("#tel_alternativo").prop("readonly", false);
  $("#cli_mail").prop("readonly", false);
  $("#cli_dir").prop("readonly", false);
  $("#cli_ciudad").prop("disabled", false);
  $("#cli_entidad").prop("disabled", false);
  $("#cli_convenio").prop("disabled", false);
  $("#est_laboral").removeAttr("disabled");
  $("#contacto").removeAttr("disabled");

  var estadolaboral = $("#est_laboral").val();
  if (estadolaboral == "ACTIVO") {
    $("#tipo_contrato").prop("disabled", false);
    $("#cli_cargo").prop("readonly", false);
    $("#tiem_servicio").prop("readonly", false);
    $("#tipo_pension").prop("disabled", true);
  } else if (estadolaboral == "PENSIONADO") {
    $("#tipo_contrato").prop("disabled", true);
    $("#cli_cargo").prop("readonly", true);
    $("#tiem_servicio").prop("readonly", false);
    $("#tipo_pension").prop("disabled", false);
  } else {
    $("#tipo_contrato").prop("disabled", false);
    $("#cli_cargo").prop("readonly", false);
    $("#tiem_servicio").prop("readonly", false);
    $("#tipo_pension").prop("disabled", false);
  }

  //  CIUDAD =  Actualizar Select2 para reflejar el estado habilitado
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
          // Transformar los datos en el formato que Select2 necesita
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
      $("#cli_dep").val(selectedCity.department);
    });
  // CONVENIO = Actualizar Select2 para reflejar el estado habilitado
  $("#cli_convenio").select2({
    placeholder: "Escribe un convenio",
    allowClear: false,
    ajax: {
      url: "../../controller/convenio.php?op=convenio",
      type: "POST",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          term: params.term.trim().toLowerCase(),
          identidad: cliente[10],
        };
      },
      processResults: function (data) {
        // Transformar los datos en el formato que Select2 necesita
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

  //TOMA CONTACTO
  $.post("../../controller/cliente.php?op=combo", function (data, status) {
    $("#contacto").html(data);
    if (cliente[19]) {
      $("#contacto").val(cliente[19]);
    }
  });
}
$("#est_laboral").on("change", function () {
  var estadolaboral = $("#est_laboral").val();
  if (estadolaboral == "ACTIVO") {
    $("#tipo_contrato").prop("disabled", false);
    $("#cli_cargo").prop("readonly", false);
    $("#tiem_servicio").prop("readonly", false);
    $("#tipo_pension").prop("disabled", true);
  } else if (estadolaboral == "PENSIONADO") {
    $("#tipo_contrato").prop("disabled", true);
    $("#cli_cargo").prop("readonly", true);
    $("#tiem_servicio").prop("readonly", false);
    $("#tipo_pension").prop("disabled", false);
  } else {
    $("#tipo_contrato").prop("disabled", false);
    $("#cli_cargo").prop("readonly", false);
    $("#tiem_servicio").prop("readonly", false);
    $("#tipo_pension").prop("disabled", false);
  }
});
$("#contacto").on("change", function () {
    listarasesor();
    listaragente();
});
$("#guardar").on("click", function (e) {
  e.preventDefault();
  $("#editar").text("Editar");
  $("#guardar").prop("disabled", true);
  var formData = new FormData($("#form_cli")[0]);
  formData.append("id", id);
  formData.append("tipo_doc", $("#tipo_doc").val());
  formData.append("cli_cc", $("#cli_cc").val());
  formData.append("cli_nombre", $("#cli_nombre").val());
  formData.append("cli_telefono", $("#cli_telefono").val());
  formData.append("cli_dep", $("#cli_dep").val());
  formData.append("idage", $("#agente").val());
  formData.append("asesor", $("#asesor").val());

  desabilitar();

  $.ajax({
    url: "../../controller/cliente.php?op=editar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      var response = JSON.parse(datos);

      if (response.status === "success") {
        buscarcliente();

        // Simular una espera de 1 segundo antes de cargar los datos
        new Promise((resolve) => setTimeout(resolve, 1000));

        var entidad = $("#cli_entidad").val();

        // Mostrar mensaje de éxito
        swal("Correcto!", response.message, "success");
      } else {
        // console.error("Error:", response.message);
        swal("Error!", response.message, "error");
      }
    },
  });
});
function desabilitar() {
  $("#tipo_doc").prop("disabled", true);
  $("#cli_cc").prop("readonly", true);
  $("#cli_nombre").prop("readonly", true);
  $("#fec_nac").prop("readonly", true);
  $("#cli_telefono").prop("readonly", true);
  $("#tel_alternativo").prop("readonly", true);
  $("#cli_mail").prop("readonly", true);
  $("#cli_dir").prop("readonly", true);
  $("#cli_ciudad").prop("disabled", true);
  $("#cli_convenio").prop("disabled", true);
  $("#est_laboral").prop("disabled", true);
  $("#tipo_contrato").prop("disabled", true);
  $("#cli_cargo").prop("readonly", true);
  $("#tiem_servicio").prop("readonly", true);
  $("#tipo_pension").prop("disabled", true);
  $("#contacto").prop("disabled", true);
  $("#agente").prop("disabled", true);
  $("#asesor").prop("disabled", true);
  $("#cli_entidad").prop("disabled", true);
}

/* INICIO OPERACIONES*/
function listaroperaciones() {
  // console.log("listarope");
  tabla = $("#operaciones_data").DataTable({
    processing: false,
    serverSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ajax: {
      url: "../../controller/operacion.php?op=listaropexcliente",
      type: "POST",
      data: {
        cli_id: id,
        perfil: usuPerfil,
      },
      dataSrc: function (response) {
        // console.log(response);
        // Cambiar el título de la columna basado en la respuesta del servidor
        $("#operaciones_data th:nth-child(6)").text(response.tituloFecha);
        return response.aaData; // Retornar los datos para que DataTables los maneje
      },
      error: function (e) {
        alert(e.responseText);
      },
    },
    destroy: true,
    responsive: true,
    info: true,
    displayLength: 10,
    autoWidth: false,
    language: {
      processing: "Procesando...",
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      emptyTable: "Ningún dato disponible en esta tabla",
      info: "Mostrando un total de _TOTAL_ registros",
      infoEmpty: "Mostrando un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      search: "Buscar:",
      loadingRecords: "Cargando...",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: ": Activar para ordenar la columna de manera ascendente",
        sortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}
function eliminar(ope_id) {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "¿Está seguro de eliminar la operación?",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Sí",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        $.post(
          "../../controller/cliente.php?op=eliminaroperaciones",
          { ope_id: ope_id },
          function (data) {
            var tipo = "Comercial";
            var detalle = "Eliminar operación";
            $.ajax({
              url: "../../controller/logs.php?op=logs",
              type: "POST",
              data: JSON.stringify({
                usu_id: usu_id,
                tipo: tipo,
                detalle: detalle,
                ip: ip,
              }),
              contentType: "application/json",
              processData: false,
              success: function (response) {},
            });

            $("#operaciones_data").DataTable().ajax.reload();

            swal({
              title: "BYAPPS::CRM",
              text: "Operación eliminada.",
              type: "success",
              confirmButtonClass: "btn-success",
            });
          }
        );
      }
    }
  );
}
function editarope(op_id) {
  var fechaes;

  $("#mdltitulop").html("Editar Operación");
  $("#btnguardar").prop("disabled", true);
  $("#ope_estado").prop("readonly", true);

  $.post(
    "../../controller/operacion.php?op=mostrar",
    { op_id: op_id },
    function (datos) {
      var data = JSON.parse(datos)[0];
      var fechacierre;

      $("#ope_id").val(op_id);
      $("#ope_numero").val(data.ope_cod);
      $("#ope_operacion").val(data.ope_ope).trigger("change");

      // Crear primera opción
      var nuevaOpcion1 = $("<option>")
        .attr("value", cliente[10])
        .text(cliente[11]);
      $("#ope_entidad").append(nuevaOpcion1);
      $("#ope_entidad").prop("disabled", true);

      cargarSucursales(data.suc_id, cliente[10]);

      var montoEnPesos = Number(data.ope_mon).toLocaleString("es-CO", {
        style: "currency",
        currency: "COP",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      });
      $("#ope_monto").val(montoEnPesos);

      var montoAprobadoEnPesos = Number(data.ope_monap).toLocaleString(
        "es-CO",
        {
          style: "currency",
          currency: "COP",
          minimumFractionDigits: 0,
          maximumFractionDigits: 0,
        }
      );
      $("#ope_maprobado").val(montoAprobadoEnPesos);

      $("#ope_plazo").val(data.ope_pla);
      $("#ope_tasa").val(data.ope_tasa);

      if (data.ope_fecie) {
        fechacierre = moment(data.ope_fecie).format("DD/MM/YYYY");
        $("#ope_fcierre").val(fechacierre);
        if (data.ope_estope == "Desembolsado" || data.ope_estope == "Negado") {
          $("#fechacierre").prop("hidden", false);
        } else {
          $("#fechacierre").prop("hidden", true);
        }
      } else {
        fechacierre = "";
      }

      if (data.ope_feest) {
        fechaes = moment(data.ope_feest).format("DD/MM/YYYY");
        $("#ope_festado").val(fechaes);
        if (data.ope_estope != "Desembolsado" && data.ope_estope != "Negado") {
          $("#cam_feest").prop("hidden", false);
        } else {
          $("#cam_feest").prop("hidden", true);
        }
      } else {
        fechaes = "";
      }

      if (data.ope_feradi) {
        fecharadi = moment(data.ope_feradi).format("DD/MM/YYYY");
        $("#ope_feradicacion").val(fecharadi);
        $("#cam_fera").prop("hidden", false);
      } else {
        fecharadi = "";
      }

      estadoinicio = data.ope_estope;
      estadoCRM = data.ope_est;

      buscarestadoentidad(cliente[10]);
    }
  );

  /* TODO: Mostrar Modal */
  $("#modaloperaciones").modal("show");
}
function cargarSucursales(suc, ident) {
  $.post(
    "../../controller/sucursal.php?op=sucursales",
    { entidad: ident },
    function (data, status) {
      $("#ope_sucursal").html(data);
      if (suc) {
        $("#ope_sucursal").val(suc);
      }
    }
  );
}
function buscarestadoentidad(ident) {
  $.post(
    "../../controller/estadosent.php?op=estadoxentidad",
    { entidad: ident },
    function (data, status) {
      $("#ope_estadoOP").html(data);
      if (estadoinicio != "") {
        $("#ope_estadoOP").val(estadoinicio);
      }
      buscarestadoCRM(ident);
    }
  );
}
function buscarestadoCRM(ident) {
  var estadoSeleccionado = $("#ope_estadoOP").val();
  $.post(
    "../../controller/estadosent.php?op=obtenerestado",
    { estado: estadoSeleccionado, entidad: ident },
    function (estadoData, estadoStatus) {
      try {
        var data = JSON.parse(estadoData);
        if (data && data.length > 0) {
          var estCrmValue = data[0].estent_estcrm;

          $("#ope_estado").val(estCrmValue);
          fechas(estCrmValue);
        } else {
          swal("La respuesta del servidor no es un objeto válido:", estadoData);
        }
      } catch (error) {
        swal("Error al buscar estadoCRM:", error);
      }
    }
  );
}
function fechas(estado) {
  $("#btnguardar").prop("disabled", false);

  if (estado == "Desembolsado" || estado == "Negado") {
    $("#fechacierre").prop("hidden", false);
    $("#cam_feest").prop("hidden", true);
  } else {
    $("#fechacierre").prop("hidden", true);
    $("#cam_feest").prop("hidden", false);
  }
}
$("#ope_estadoOP").on("change", function () {
  if ($("#mdltitulop").html() != "Nueva Operación") {
    $("#btnguardar").prop("disabled", true);
    var ent = $("#ope_entidad").val();
    buscarestadoCRM(ent);
  }
});
$("#NuevaOperacion").on("click", function () {
  $("#mdltitulop").html("Nueva Operación");
  $("#ope_id").val("");
  $("#ope_numero").val("");
  $("#ope_operacion").val($("#ope_operacion option:first").val());
  var nuevaOpcion = $("<option>").attr("value", cliente[10]).text(cliente[11]);
  $("#ope_entidad").append(nuevaOpcion);
  $("#ope_entidad").val(cliente[10]);
  $("#ope_entidad").prop("disabled", true);
  $("#ope_monto").val("$0");
  $("#ope_maprobado").val("$0");
  $("#ope_plazo").val("0");
  $("#ope_tasa").val("0.0");
  $("#ope_estado").prop("readonly", true);
  $("#cam_fera").prop("hidden", false);
  $("#ope_feradicacion").val(moment().format("DD/MM/YYYY"));
  $("#modaloperaciones").modal("show");
  $("#btnguardar").prop("disabled", true);
  cargarSucursales("", cliente[10]);
  buscarEstadonuevaop();
});
function buscarEstadonuevaop() {
  $.post(
    "../../controller/estadosent.php?op=estadosradicadosxentidad",
    { entidad: cliente[10] },
    function (data, status) {
      $("#ope_estadoOP").html(data);
      buscarestadoCRMnuevaop();
    }
  );
}
function buscarestadoCRMnuevaop() {
  var estado = "Radicacion";
  var nuevoestadoCRM = $("<option>").attr("value", estado).text(estado);
  $("#ope_estado").append(nuevoestadoCRM);
  $("#ope_estado").val(estado);
  $("#btnguardar").prop("disabled", false);
}
$("#btnguardar").on("click", function (e) {
  e.preventDefault();
  guardaryeditaroperacion();
});
function guardaryeditaroperacion() {
  var titulo = $("#mdltitulop").text();
  if (titulo == "Nueva Operación") {
    validarnumop();
  } else {
    registrar();
  }
}
function validarnumop() {
  var numop = $("#ope_numero").val();

  if (numop != "") {
    $.ajax({
      url: "../../controller/operacion.php?op=validarope",
      type: "POST",
      data: { ope_numero: numop, ope_entidad: cliente[10] },
      success: function (datos) {
        var respuesta = JSON.parse(datos);
        var valor = respuesta[0]["count(ope_id)"];
        if (valor != 0) {
          swal({
            title: "BYAPPS::CRM",
            text: "Error: El codigo de operacion ya existe.",
            type: "warning",
            confirmButtonClass: "btn-success",
          });
        } else {
          registrar();
        }
      },
    });
  } else {
    registrar();
  }
}
function registrar() {
  var formData = new FormData($("#operaciones_form")[0]);
  formData.append("id_cli", id);
  formData.append("ident", cliente[10]);

  $.ajax({
    url: "../../controller/operacion.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      // console.log(datos);
      var estado = $("#ope_estado").val();      

      if (datos == "1") {
        $("#cam_fera").prop("hidden", true);
        $("#operaciones_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaloperaciones").modal("hide");
        $("#operaciones_data").DataTable().ajax.reload();
        listaroperaciones();

        // Registro de log
        registrarLog("Operacion Creada en " + estado);

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#operaciones_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaloperaciones").modal("hide");
        $("#operaciones_data").DataTable().ajax.reload();
        listaroperaciones();

        // Registro de log
        registrarLog("Operacion Editada en " + estado);

        /* TODO:Mensaje de Confirmacion */
        if (estado == "Desembolsado" || estado == "Negado") {
          swal(
            {
              title: "BYAPPS::CRM",
              text: "Desea cerrar el cliente?",
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
                  "../../controller/cliente.php?op=edestado",
                  { id_cli: id, selectedValue: "Cerrado" },
                  function (data) {}
                );
                swal({
                  title: "BYAPPS::CRM",
                  text: "Actualizado Correctamente.",
                  type: "success",
                  confirmButtonClass: "btn-success",
                });
                buscarcliente();
              }
            }
          );
        } else {
          swal({
            title: "BYAPPS::CRM",
            text: "Actualizado Correctamente.",
            type: "success",
            confirmButtonClass: "btn-success",
          });
        }

      } else {
        listaroperaciones();
        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Error al registrar la operación.",
          icon: "error",
          buttons: {
            confirm: {
              text: "OK",
              className: "btn-danger",
            },
          },
        });
      }
    },
    error: function () {
      // Manejar errores de AJAX
      swal({
        title: "BYAPPS::CRM",
        text: "Error en la comunicación con el servidor.",
        icon: "error",
        buttons: {
          confirm: {
            text: "OK",
            className: "btn-danger",
          },
        },
      });
    },
  });
}
function registrarLog(detalle) {
  $.ajax({
    url: "../../controller/logs.php?op=logs",
    type: "POST",
    data: JSON.stringify({
      usu_id: usu_id,
      tipo: "Comercial",
      detalle: detalle,
      ip: ip,
    }),
    contentType: "application/json",
    processData: false,
    success: function (response) {},
    error: function () {
      swal("Error al registrar el log.");
    },
  });
}
function ocultarElementosYResetearFormulario() {
  $("#cam_fera").prop("hidden", true);
  $("#cam_feest").prop("hidden", true);
  $("#fechacierre").prop("hidden", true);
  $("#operaciones_form")[0].reset();
}
$("#btncerrar, #close").on("click", ocultarElementosYResetearFormulario);

/* INICIO COMENTARIOS*/
function mostrarcomentarios() {
  $.post(
    "../../controller/cliente.php?op=listarcomentarios",
    { cli_id: id, usuPerfil: usuPerfil, offset: offset, limit: limit },
    function (data) {
      $("#lblcomentarios").html(data); // Carga inicial de los primeros 10 comentarios
      offset += limit; // Incrementa el offset para la siguiente carga
    }
  );
}
function cargarMasComentarios() {
  $.post(
    "../../controller/cliente.php?op=listarcomentarios",
    { cli_id: id, usuPerfil: usuPerfil, offset: offset, limit: limit },
    function (data) {
      $("#btnMostrarMas").remove(); // Elimina el botón "Mostrar más" antes de agregar nuevos comentarios
      $("#lblcomentarios").append(data); // Añade los siguientes 10 comentarios
      offset += limit; // Incrementa el offset para la siguiente carga
    }
  );
}
$(document).on("click", "#btnenvcoment", function () {
  var privacidad = $("#com_pri_label").text();

  $("#com_coment").next(".text-danger").remove();
  var com_coment = $("#com_coment").val();

  if (com_coment === "" || com_coment === "<p><br></p>") {
    $(
      "<small class='text-muted text-danger'>No haz escrito ningún comentario</small>"
    ).insertAfter("#com_coment");
  } else {
    if (privacidad == "Público") {
      privacidad = 1;
    } else if (privacidad == "Privado") {
      privacidad = 2;
    } else {
      privacidad = 1;
    }
    var valor = offset;

    $.ajax({
      url: "../../controller/cliente.php?op=insertcoments",
      type: "POST",
      data: {
        id_cli: id,
        id_com: idcom,
        com_coment: com_coment,
        usu_id: usu_id,
        privacidad: privacidad,
      },
      success: function (datos) {
        if (datos == 1) {
          swal("Correcto!", "Comentario agregado correctamente: ", "success");
          offset = 0;
          mostrarcomentarios();
        } else {
          swal("Correcto!", "Comentario editado correctamente: ", "success");
          offset = valor -= limit;
          mostrarcomentarios();
        }
      },
    });

    $("#com_coment").next(".text-danger").remove();
    $("#com_coment").summernote("reset");
    $("#modalcomentarios").modal("hide");
  }
});
$(document).on("click", "#addcoment", function () {
  idcom = "";
  /* TODO:Mostrar Modal */
  $("#modalcomentarios").modal("show");
});
function enviarDatosComentario(comId, comPrioridad, com) {
  idcom = comId;

  if (comPrioridad == 1) {
    $("#com_pri_label").text("Público");
  } else {
    $("#com_pri_label").text("Privado");
  }

  $("#com_pri").prop("checked", comPrioridad === 2);

  $("#com_coment").summernote("code", com);

  /* TODO:Mostrar Modal */
  $("#modalcomentarios").modal("show");
}
$("#com_pri").click(function () {
  if ($(this).is(":checked")) {
    $("#com_pri_label").text("Privado");
  } else {
    $("#com_pri_label").text("Público");
  }
});
function toggleCheckbox(comentarioId) {
  let isChecked = document.getElementById(
    "check-toggle-" + comentarioId
  ).checked;
  let estado = isChecked ? 2 : 1;
  let nomestado = estado === 1 ? "Público" : "Privado";

  swal(
    {
      title: "BYAPPS::CRM",
      text: "¿Está seguro de cambiar el comentario a estado " + nomestado + "?",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Sí",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
      if (isConfirm) {
        $.post(
          "../../controller/cliente.php?op=editarprivacidadcomentario",
          { com_id: comentarioId, estado: estado },
          function (data) {
            // Mostrar mensaje de éxito
            swal({
              title: "BYAPPS::CRM",
              text: "Comentario Editado.",
              type: "success",
              confirmButtonClass: "btn-success",
            });
          }
        );
      }
      // Restaurar estado del checkbox y label si no se confirma
      else {
        let textoLabel = isChecked ? "Privado" : "Público";
        $("#check-toggle-" + comentarioId)
          .next("label")
          .text();
      }
    }
  );
}

//CONSULTA
$("#con_pri").click(function () {
  if ($(this).is(":checked")) {
    $("#con_pri_label").text("Privado");
  } else {
    $("#con_pri_label").text("Público");
  }
});
$(document).on("click", "#resconsult", function () {
  $.ajax({
    url: "../../controller/cliente.php?op=consulta",
    type: "POST",
    data: { id_cli: id },
    success: function (datos) {
      var response = JSON.parse(datos);

      if (response.length === 0) {
        swal("Error!", "No existe una consulta de este cliente. ", "error");
      } else {
        var primerObjeto = response[0];
        con_id = primerObjeto.con_id;
        /* TODO:Ocultar Modal */
        $("#modalconsulta").modal("show");
      }
    },
  });
});
$("#btnconsulta").on("click", function (e) {
  var fecon = $("#ope_feconsulta").val();
  var resp = $("#con_resp").val();
  var desc = $("#com_consult").summernote("code");

  if (usuPerfil == "Asesor" || usuPerfil == "Coordinador") {
    var pri = 1;
  } else {
    var pri = $("#con_pri_label").text();
    if (pri == "Público") {
      pri = 1;
    } else if (pri == "Privado") {
      pri = 2;
    } else {
      pri = 1;
    }
  }

  if (desc.trim() === "" || $(desc).text().trim() === "") {
    e.preventDefault();

    swal("Error!", "La descripción es obligatoria.", "warning");
    return;
  }

  $.ajax({
    url: "../../controller/cliente.php?op=editarconsulta",
    type: "POST",
    data: {
      fecon: fecon,
      resp: resp,
      desc: desc,
      id_cli: id,
      pri: pri,
      con_id: con_id,
    },
    success: function (datos) {
      var response = JSON.parse(datos);

      if (response.status === "success") {
        offset = 0;
        mostrarcomentarios();
        buscarcliente();
        $("#com_consult").summernote("reset");
        /* TODO:Ocultar Modal */
        $("#modalconsulta").modal("hide");
        swal("Correcto!", "Consulta guardada", "success");
      } else {
        // console.error("Error:", response.message);
        alert("Error!", response.message, "error");
      }
    },
    error: function (error) {
      // console.error("Error al enviar la solicitud AJAX:", error);
      alert("Error!", "Ocurrió un error al guardar la consulta.", "error");
    },
  });
});

//TAREAS
function listarTareas() {
  tabla = $("#tareas_data").DataTable({
    processing: false,
    serverSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ajax: {
      url: "../../controller/tareas.php?op=listartareasCli",
      type: "POST",
      data: {
        id: id,
      },
      error: function (e) {
        swal(e.responseText);
      },
    },
    destroy: true,
    responsive: true,
    info: true,
    displayLength: 10,
    autoWidth: false,
    language: {
      processing: "Procesando...",
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      emptyTable: "Ningún dato disponible en esta tabla",
      info: "Mostrando un total de _TOTAL_ registros",
      infoEmpty: "Mostrando un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      search: "Buscar:",
      loadingRecords: "Cargando...",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending: ": Activar para ordenar la columna de manera ascendente",
        sortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}
$("#NuevaTarea").on("click", function () {
  $("#mdltituloT").html("Nueva Tarea");

  limpiar();
  cliente2();

  $("#descrip").hide();

  //estado
  var estadoSelect = $("#tar_est");
  estadoSelect.html(`
      <option value="1" selected>NUEVA</option>
      <option value="2">EN CURSO</option>
    `);

  // Configura el editor para la nueva tarea
  $("#tar_com").summernote({
    popover: false,
    height: 200,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    callbacks: {
      onInit: function () {
        // Mostrar la barra de redimensionamiento al inicializar
        $(this).next(".note-editor").find(".note-resizebar").show();
      },
    },
  });

  $("#divcreado").hide();

  $("#modaltarea").modal("show");
});
function limpiar() {
  $("#tar_id").val("");
  $("#tar_asun").val("");
  $("#tar_det").val("");
  $("#protected-summernote").summernote("code", "");
  $("#protected-summernote").hide();
  $("#tar_com").summernote("code", "");
  $("#creado").html("");
  $("#tar_asig").val("").trigger("change");
  $("#tar_cli").val("").trigger("change");
  $("#tar_cat").val(1);
  $("#tar_pri").val(1);
  var currentDate = moment().format("DD/MM/YYYY");
  $("#tar_fcierre").val(currentDate);
  $("#tar_est").val(1);
  $("#tar_asun").prop("disabled", false);
  $("#tar_det").prop("disabled", false);
  $("#tar_asig").prop("disabled", false);
  $("#tar_cli").prop("disabled", false);

  $("#protected-content-container").hide();
}
function asignadoa() {
  $.post("../../controller/tareas.php?op=usu", function (data) {
    listarDatos();

    var data = JSON.parse(data);

    usuPerfil = data.perfil;
    if (usuPerfil == "Asesor") {
      $.post("../../controller/tareas.php?op=usu", function (data) {
        var data = JSON.parse(data);

        $("#tar_asig").html(
          '<option value="' + data.id + '">' + data.nom + "</option>"
        );
        $("#tar_asig").val(data.id).trigger("change");
        $("#tar_asig").prop("disabled", true);
      });
    } else {
      $("#tar_asig").select2({
        placeholder: "Asigna a un Usuario",
        allowClear: true,
        ajax: {
          url: "../../controller/usuario.php?op=adminselect",
          type: "POST",
          dataType: "json",
          delay: 250,
          data: function (params) {
            return {
              term: params.term.trim().toLowerCase(),
              usuPerfil: usuPerfil,
            };
          },
          processResults: function (data) {
            return {
              results: data.map(function (item) {
                return {
                  id: item.usu_id,
                  text: item.usu_usu,
                };
              }),
            };
          },
          cache: true,
        },
        minimumInputLength: 2,
      });
    }
  });
}
function cliente2() {
  $.post(
    "../../controller/tareas.php?op=cliente2",
    { id: id },
    function (data) {
      asignadoa();
      // Actualiza el elemento select
      var $select = $("#tar_cli");
      // Primero, elimina las opciones existentes si es necesario
      $select.empty();
      // Agrega la nueva opción
      $select.append($("<option></option>").val(data).text(nombre));
      // Deshabilita el select
      $select.prop("disabled", true);
    }
  );
}
function listarDatos() {
  return $.post("../../controller/tareas.php?op=combocat")
    .done(function (data) {
      $("#btnguardar2").prop("disabled", false);

      $("#tar_cat").html(data);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      $("#btnguardar").prop("disabled", false);

      swal("Error al cargar datos:", textStatus, errorThrown);
    });
}
$("#tarea2_form").on("submit", function (e) {
  guardaryeditar(e);
});
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#tarea2_form")[0]);
  var cli = $("#tar_cli").val();
  formData.append("tar_cli", cli);

  $.ajax({
    url: "../../controller/tareas.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#tarea2_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaltarea").modal("hide");
        $("#tareas_data").DataTable().ajax.reload();
        listarTareas();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#tarea2_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaltarea").modal("hide");
        $("#tareas_data").DataTable().ajax.reload();
        listarTareas();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else {
        swal("Error con el registro : " + datos + ".");
      }
    },
  });
}
function editar(
  id,
  asun,
  det,
  comen,
  idasigpor,
  asigpor,
  idasiga,
  asiga,
  idcli,
  cli,
  clas,
  pri,
  feve,
  usu,
  est
) {
  $("#descrip").show();
  $("#protected-content-container").show();
  $("#protected-summernote").show();
  $("#divcreado").show();
  $("#tar_com").summernote("code", "");

  if (usu == idasigpor) {
    $("#tar_asun").prop("disabled", false);
    $("#tar_det").prop("disabled", false);
    $("#tar_asig").prop("disabled", false);
    $("#tar_cli").prop("disabled", false);
    asignadoa();
    cliente2();
  } else {
    $("#tar_asun").prop("disabled", true);
    $("#tar_det").prop("disabled", true);
    $("#tar_asig").prop("disabled", true);
    $("#tar_cli").prop("disabled", true);
  }

  $("#mdltituloT").html("Editar Tarea");
  $("#tar_id").val(id);
  $("#tar_asun").val(asun);
  $("#tar_det").val(det);
  $("#creado").html(asigpor);

  //asignado a
  $("#tar_asig").html('<option value="' + idasiga + '">' + asiga + "</option>");
  $("#tar_asig").val(idasiga).trigger("change");

  //cliente
  $("#tar_cli").html('<option value="' + idcli + '">' + cli + "</option>");
  $("#tar_cli").val(idcli).trigger("change");

  $("#tar_cat").val(clas);
  $("#tar_pri").val(pri);
  $("#tar_fcierre").val(feve);

  //estado
  var estadoSelect = $("#tar_est");
  estadoSelect.html(`
    <option value="1" ${est === "1" ? "selected" : ""}>NUEVA</option>
    <option value="2" ${est === "2" ? "selected" : ""}>EN CURSO</option>
    <option value="3" ${est === "3" ? "selected" : ""}>COMPLETADA</option>
    <option value="4" ${est === "4" ? "selected" : ""}>VENCIDA</option>
    <option value="5" ${est === "5" ? "selected" : ""}>ELIMINADA</option>
  `);

  // Destruye la instancia previa de Summernote (si existe)
  if ($("#protected-summernote").data("summernote")) {
    $("#protected-summernote").summernote("destroy");
  }

  // Inicializar Summernote para #protected-summernote
  $("#protected-summernote")
    .on("summernote.init", function () {
      $(this).next(".note-editor").find(".note-resizebar").hide(); // Ocultar barra de redimensionamiento solo para este editor
    })
    .summernote({
      toolbar: false,
      placeholder: "Este contenido es solo de lectura.",
      callbacks: {
        onInit: function () {
          var contentHeight = $("#protected-summernote").summernote(
            "scrollHeight"
          );
          $("#protected-summernote").summernote("height", contentHeight);
        },
      },
    });

  $("#protected-summernote").summernote("code", comen);

  // Ajustar la altura después de establecer el contenido
  setTimeout(function () {
    var contentHeight = $("#protected-summernote").summernote("scrollHeight");
    $("#protected-summernote").summernote("height", contentHeight);
  }, 0); // Usar timeout para asegurar que el contenido esté renderizado

  // Hacer el editor solo lectura
  $("#protected-summernote").summernote("disable");

  $(".note-editable").css({
    "line-height": "1.2", // Ajusta la altura de línea según sea necesario
    margin: "0", // Elimina márgenes adicionales
    padding: "0", // Elimina relleno adicional
  });

  // Específicamente para párrafos
  $(".note-editable p").css({
    "margin-top": "0", // Elimina el margen superior
    "margin-bottom": "0.2em", // Ajusta el margen inferior según sea necesario
  });

  // Configura el editor para la nueva tarea
  $("#tar_com").summernote({
    popover: false,
    height: 200,
    lang: "es-ES",
    toolbar: [
      ["style", ["bold", "italic", "underline", "clear"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
    ],
    callbacks: {
      onInit: function () {
        // Mostrar la barra de redimensionamiento al inicializar
        $(this).next(".note-editor").find(".note-resizebar").show();
      },
    },
  });

  /* TODO:Mostrar Modal */
  $("#modaltarea").modal("show");
}

//DOCUMENTOS
function listarcategorias() {
  $.ajax({
    url: "../../controller/documentosclientes.php?op=buscarcategorias",
    method: "POST",
    data: { perfil: usuPerfil },
    success: function (response) {
      categorias = response;
      var $lista = $(".files-manager-side-list");

      // Limpiar elementos existentes, excluyendo los dividers
      $lista.find("li:not(.dropdown-divider)").remove();
      $lista.find(".dropdown-divider").remove(); // Eliminar dividers existentes

      // Iterar sobre las categorías recibidas y agregar nuevas listas <li>
      $(response).each(function (index, item) {
        var $nuevoElemento = $('<li><a href="#">' + item.label + "</a></li>");
        $nuevoElemento.data("index", item.value); // Guardar el índice en el elemento
        $nuevoElemento.data("label", item.label); // Guardar el nombre de la categoría en el elemento
        $lista.append($nuevoElemento);
      });

      // Agregar divider y Papelera al final
      if (usuPerfil != "Asesor" && usuPerfil != "Coordinador") {
        $lista.append('<div class="dropdown-divider"></div>');
        var $papeleraElemento = $(
          '<li><a href="#" class="3">PAPELERA</a></li>'
        );
        $papeleraElemento.data("index", 0); // Asignar índice 0 a Papelera
        $papeleraElemento.data("label", "PAPELERA"); // Guardar el nombre "Papelera" en el elemento
        $lista.append($papeleraElemento);
      }

      // Agregar manejador de eventos click a los elementos de la lista
      $lista.find("li a").click(function (e) {
        e.preventDefault();
        var $parent = $(this).parent();
        idcat = $parent.data("index");
        label = $parent.data("label");

        // Ocultar el icono de edición si la categoría es "Papelera" o "Sin categoría"
        if (label === "PAPELERA" || label === "SIN CATEGORIA") {
          $("#edit-icon").hide();
          $("#eliminarcat").hide();
        } else {
          $("#edit-icon").show();
          $("#eliminarcat").show();
        }

        if (idcat !== null) {
          $("#nomcat").html(label);
          buscarDocumentos(idcat);
        } else {
          swal("Elemento sin índice asociado.");
        }
      });

      // Buscar documentos para el primer elemento de la lista
      if (inicio) {
        var $primerElemento = $lista.find("li:first-child");
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
            buscarDocumentos(primerIndex, primerLabel);
          }
        }
      }
    },
    error: function (error) {
      swal("Error al listar categorías:", error);
    },
  });
}
function buscarDocumentos(idcatd) {
  idcat = idcatd;
  $("#entidad_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    searching: false,
    lengthChange: false,
    colReorder: true,
    ordering: false,
    ajax: {
      url: "../../controller/documentosclientes.php?op=documentosxidcat",
      type: "post",
      dataType: "json",
      data: {
        idcat: idcatd,
        label: label,
        usuPerfil: usuPerfil,
        id_cli: id,
      },
      error: function (e) {
        swal(e.responseText);
      },
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 5,
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
      $.ajax({
        url: "../../controller/documentosclientes.php?op=guardar_titulo",
        method: "POST",
        data: { idcat: idcat, titulo: newText },
        success: function (response) {
          inicio = false;
          listarcategorias();
        },
        error: function (error) {
          awal("Error al guardar el título:", error);
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
          "../../controller/documentosclientes.php?op=eliminarcategoria",
          { idcat: idcat },
          function (data) {}
        );
        swal({
          title: "BYAPPS::CRM",
          text: "Categoria Eliminada.",
          type: "success",
          confirmButtonClass: "btn-success",
        });

        idcat = null;
        listarcategorias();
      }
    }
  );
});
$(document).on("click", "#addDoc", function () {
  $("#titulodoc").text("Nuevo documento");
  $("#sel_doc").prop("hidden", false);
  $("#doc_nombre").prop("disabled", false);
  $("#doc_clas").prop("disabled", false);
  $("#doc_cat").prop("disabled", false);
  $("#fileTest").prop("disabled", false);
  clasificacion("no");
  $("#doc_cat").html(categorias);
  $("#documentos_form")[0].reset();
  $("#doci_id").val("");
  $("#fileIcons").empty();

  /* TODO:Mostrar Modal */
  $("#modaldocumentos").modal("show");
});
function clasificacion() {
  var select = document.getElementById("doc_clas");
  // Limpiar las opciones existentes
  select.innerHTML = "";

  if (usuPerfil != "Asesor" && usuPerfil != "Coordinador") {
    // Crear y agregar la opción "Público"
    var optionPublico = document.createElement("option");
    optionPublico.value = 1;
    optionPublico.text = "Público";
    select.appendChild(optionPublico);

    // Crear y agregar la opción "Privado"
    var optionPrivado = document.createElement("option");
    optionPrivado.value = 2;
    optionPrivado.text = "Privado";
    select.appendChild(optionPrivado);
  } else {
    // Crear y agregar la opción "Público"
    var optionPublico = document.createElement("option");
    optionPublico.value = 1;
    optionPublico.text = "Público";
    select.appendChild(optionPublico);
  }
}
$("#documentos_form").on("submit", function (e) {
  e.preventDefault();

  var formData = new FormData(this);
  formData.append("usu_id", usu_id);
  formData.append("id", id);

  var titulo = $("#titulodoc").text();

  // Verificar si se ha seleccionado un documento
  if (titulo == "Nuevo documento") {
    if ($("#fileTest")[0].files.length === 0) {
      swal("Por favor, seleccione un documento antes de guardar.");
      return;
    }
  }

  // Bloquear el botón de envío y mostrar el símbolo de carga
  var $guardarBtn = $("#guardardoc");
  $("#doc_nombre").prop("disabled", true);
  $("#doc_clas").prop("disabled", true);
  $("#doc_cat").prop("disabled", true);
  $("#fileTest").prop("disabled", true);

  $guardarBtn.prop("disabled", true);
  $guardarBtn.html('<i class="fa fa-spinner fa-spin"></i> Guardando...');

  $.ajax({
    url: "../../controller/documentosclientes.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data == "1") {
        buscarDocumentos(idcat);
        $("#documentos_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modaldocumentos").modal("hide");

        //   /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Documento Guardado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (data == "2") {
        buscarDocumentos(idcat);
        $("#documentos_form")[0].reset();
        //   /* TODO:Ocultar Modal */
        $("#modaldocumentos").modal("hide");
        swal({
          title: "BYAPPS::CRM",
          text: "Documento Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else {
        swal("Error!", "Fallo al guardar el Documento. ", "warning");
      }
      // Desbloquear el botón de envío y restaurar el texto original
      $guardarBtn.prop("disabled", false);
      $guardarBtn.html("Guardar");
    },
    error: function (error) {
      swal("Error al enviar la solicitud AJAX:", error);

      // Desbloquear el botón de envío y restaurar el texto original
      $guardarBtn.prop("disabled", false);
      $guardarBtn.html("Guardar");
    },
  });
});
function editardoc(doci_id, nombre, clas, cat) {
  $("#titulodoc").text("Editar documento");
  clasificacion();
  $("#doc_cat").html(categorias);
  $("#doc_cat").val(cat);
  $("#doci_id").val(doci_id);
  $("#doc_nombre").val(nombre);
  $("#doc_clas").val(clas);
  $("#sel_doc").prop("hidden", true);

  /* TODO:Mostrar Modal */
  $("#modaldocumentos").modal("show");
}
function eliminardoc(iddoc) {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "Esta seguro de Eliminar el archivo?",
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
          "../../controller/documentosclientes.php?op=eliminardoc",
          { iddoc: iddoc },
          function (data) {}
        );
        buscarDocumentos(idcat);

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
$(document).on("click", "#btn_newcat", function () {
  $("#mdltitulo2").html("Crear Categoria");
  $("#modalcategoria").modal("show");
});
$("#categoria_form").on("submit", function (e) {
  e.preventDefault();
  var nombrecat = $("#cat_nombre").val().toUpperCase();
  var clascat = $("#cat_clas").val();

  $.ajax({
    url: "../../controller/documentosclientes.php?op=crearcategoria",
    type: "POST",
    data: { nombrecat: nombrecat, clascat: clascat },
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
// function ver(ruta){
//   var url = "https://api.whatsapp.com/send?phone=57" + telefono;
//   window.open(url);
// }

//DISKET
$(document).on("click", "#pdfcliente", function (e) {
  e.preventDefault();
  // Crear el objeto FormData
  var formData = new FormData();
  formData.append("id", id);

  fetch("../../controller/cliente.php?op=PDFhojadevidacli", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      // Verificar el tipo de contenido de la respuesta
      if (response.headers.get("Content-Type").includes("application/json")) {
        return response.json(); // Leer JSON si es una respuesta de error
      }
      return response.blob(); // Leer el archivo si es una respuesta de archivo
    })
    .then((data) => {
      if (data.error) {
        // Mostrar mensaje de error
        Swal.fire({
          icon: "warning",
          title: "Error",
          text: data.error,
        });
      } else {
        // Crear un enlace para descargar el archivo
        var url = window.URL.createObjectURL(data);
        var a = document.createElement("a");
        a.href = url;
        a.download = "mi_pdf_directo.pdf"; // Nombre del archivo a descargar
        document.body.appendChild(a);
        a.click(); // Iniciar la descarga
        a.remove(); // Limpiar
      }
    })
    .catch((error) => swal("Error al generar el PDF:", error));
});

// CONFIGURACION
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
$("#com_coment").summernote({
  popover: false,
  height: 150,
  lang: "es-ES",

  toolbar: [
    ["style", ["bold", "italic", "underline", "clear"]],
    ["font", ["strikethrough", "superscript", "subscript"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["height", ["height"]],
  ],
});
$("#com_consult").summernote({
  popover: false,
  height: 150,
  lang: "es-ES",

  toolbar: [
    ["style", ["bold", "italic", "underline", "clear"]],
    ["font", ["strikethrough", "superscript", "subscript"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["height", ["height"]],
  ],
});
$("#tar_des").summernote({
  popover: false,
  height: 150,
  lang: "es-ES",

  toolbar: [
    ["style", ["bold", "italic", "underline", "clear"]],
    ["font", ["strikethrough", "superscript", "subscript"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["height", ["height"]],
  ],
});

init();

// var entidad = cliente[11];
// var entid = cliente[10];
