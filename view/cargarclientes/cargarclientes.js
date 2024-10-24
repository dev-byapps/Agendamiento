var ident;
var estadoCRM;
var idcli;
var idope;
var cccliente;
var nooperacion;
var progresoActual = 0;

function init() {}

$(document).ready(function () {
  $("#cargar").on("click", function () {
    var datos;
    var asesor;
    var entidad;
    var entidadOpe;
    var idase;

    var totalClientes = 0;
    var input = document.getElementById("fileTest");

    if (input.files.length > 0) {
      var file = input.files[0];

      if (file) {
        $("#barraP").show();
        var reader = new FileReader();
        reader.onload = function (e) {
          var lineas = e.target.result.split("\n");

          function contarLineasConDatos() {
            return lineas.reduce(function (contador, linea) {
              datos = linea.split(";");
              // Verificar si algún campo no está en blanco
              if (datos.some((campo) => campo.trim() !== "")) {
                return contador + 1;
              }
              return contador;
            }, 0);
          }

          totalClientes = contarLineasConDatos() - 1;
          $("#total_clientes").text(totalClientes);

          function actualizarProgreso() {
            progresoActual = progresoActual + 1;
            // console.log(progresoActual);
            $("#progreso_actual").text(progresoActual);
            // Actualizar la barra de progreso
            var porcentaje = (progresoActual / totalClientes) * 100;
            $("#progreso").val(porcentaje.toFixed(2));
            // Puedes ajustar aquí el aumento de la barra de progreso
          }

          function procesarLinea(linea, indice) {
            return new Promise(function (resolve, reject) {
              if (indice == 0) {
                actualizarProgreso();
                resolve();
                return;
              }

              datos = linea.split(";");
              asesor = datos[9];
              cccliente = datos[0];
              nooperacion = datos[10];
              entidad = datos[8];
              entidadOpe = datos[12];

              if (asesor != "" && asesor != "ASESOR" && asesor != undefined) {
                validarUsuario(asesor)
                  .then(() => {
                    actualizarProgreso();

                    if (progresoActual === totalClientes) {
                      $("#completado").text("Carga completada");
                      swal({
                        title: "Completado",
                        text: "Datos cargados con éxito.",
                        icon: "success",
                        buttons: {
                          confirm: {
                            text: "OK",
                            value: true,
                            visible: true,
                            className: "btn btn-success",
                          },
                        },
                      });

                      // Limpia la información después de hacer clic en OK
                      limpiarInformacion();
                    }

                    resolve();
                  })
                  .catch(function (error) {
                    reject(error);
                  });
              }
            });
          }

          function limpiarInformacion() {
            $("#barraP").hide();
            $("#completado").text("");
            $("#progreso").val(0);
            $("#progreso_actual").text("0");
            $("#total_clientes").text("0");
            $("#fileTest").val("");
          }

          function validarUsuario(asesor) {
            return new Promise(function (resolve, reject) {
              $.ajax({
                type: "POST",
                url: "../../controller/usuario.php?op=Basesorxcc",
                data: { cedula: asesor },
                success: function (response) {
                  // console.log("1. validar usuario: ", response);
                  var data = JSON.parse(response);
                  var existeUsuario = data[0]["COUNT(usu_id)"];

                  if (existeUsuario == 0) {
                    // Usuario no existe, lo creamos
                    crearUsuario().then(resolve).catch(reject);
                  } else {
                    // Usuario ya existe, pasamos a la validación del cliente
                    validarCliente(cccliente).then(resolve).catch(reject);
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  var errorMessage = "Error al validar usuario";
                  if (jqXHR.responseText) {
                    errorMessage += ": " + jqXHR.responseText;
                  }
                  swal(
                    "Error: Error al validar al usuario " +
                      asesor +
                      " en la linea " +
                      progresoActual +
                      "\n" +
                      "Mensaje de error: " +
                      (errorMessage + "\n" + jqXHR.responseText),
                    "error"
                  );
                  reject(errorMessage);
                },
              });
            });
          }

          function crearUsuario() {
            // console.log("1.5. crear usuario");
            return new Promise(function (resolve, reject) {
              $.ajax({
                type: "POST",
                url: "../../controller/usuario.php?op=guardaryeditar",
                data: {
                  usu_user: asesor,
                  usu_pass: asesor,
                  usu_nom: asesor,
                  usu_cc: asesor,
                  usu_mail: "",
                  usu_perfil: "Asesor",
                  usu_grupocom: null,
                  sip_cuenta: null,
                  sip_ext: "",
                  sip_pass: "",
                  usu_est: 1,
                },
                success: function (response) {
                  // console.log("1.5. crear usuario:", response);
                  validarCliente(cccliente).then(resolve).catch(reject);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  var errorMessage = "Error al crear usuario";
                  if (jqXHR.responseText) {
                    swal(
                      "Error: \n Error al crear usuario " +
                        asesor +
                        " en la linea " +
                        progresoActual +
                        "\n" +
                        "error"
                    );
                  }
                  reject(errorMessage);
                },
              });
            });
          }

          function validarCliente(cccliente) {
            // console.log("2. validar cliente: ", cccliente);
            return new Promise(function (resolve, reject) {
              if (!cccliente.trim()) {
                resolve();
              } else {
                cccliente = cccliente.replace(/\./g, "");
                // console.log(cccliente);
                $.ajax({
                  type: "POST",
                  url: "../../controller/cliente.php?op=buscarxCC",
                  data: { documento: cccliente },
                  success: function (response) {
                    // console.log("2. validar cliente;", response);
                    var data = JSON.parse(response);
                    var totalClientes = data[0].total_clientes;

                    if (totalClientes == 0) {
                      // Usuario no existe, lo creamos
                      crearCliente(cccliente).then(resolve).catch(reject);
                    } else {
                      editarCliente(cccliente).then(resolve).catch(reject);
                    }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                    var errorMessage = "Error al validar cliente";
                    if (jqXHR.responseText) {
                      swal(
                        "Error: \n Error al validar cliente " +
                          cccliente +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      );
                    }
                    reject(errorMessage);
                  },
                });
              }
            });
          }

          function crearCliente(cccliente) {
            // console.log("2.5. Crear cliente: ", cccliente);
            return new Promise(async function (resolve, reject) {
              var nombre = datos[1];
              var edad = datos[2];
              var telefono = datos[3];
              var ciudad = datos[4];
              var convenio = datos[5];
              var estado = datos[6];
              if (
                estado == "Interesado" ||
                estado == "Analisis" ||
                estado == "Consulta" ||
                estado == "Viable" ||
                estado == "Oferta" ||
                estado == "Retoma" ||
                estado == "No viable" ||
                estado == "No interesado" ||
                estado == "Operacion" ||
                estado == "Cerrado"
              ) {
                estado = estado;
              } else {
                estado = "Sin estado";
              }
              var fcreacion = datos[7];
              if (moment(fcreacion, "DD/MM/YYYY", true).isValid()) {
                fcreacion = moment(fcreacion, "DD/MM/YYYY").format(
                  "YYYY-MM-DD"
                );
              } else {
                fcreacion = moment().format("YYYY-MM-DD");
              }
              var entidad = datos[8];
              var toma_contac = 3; //busque que va

              try {
                await identidad(entidad);
                await idasesor(asesor);
                $.ajax({
                  type: "POST",
                  url: "../../controller/cliente.php?op=insertclixdoc",
                  data: {
                    cli_cc: cccliente,
                    cli_nombre: nombre,
                    cli_edad: edad,
                    cli_telefono: telefono,
                    cli_ciudad: ciudad,
                    cli_entidad: ident,
                    cli_estado: estado,
                    cli_convenio: convenio,
                    cli_asesor: idase,
                    fcreacion: fcreacion,
                    toma_contac: toma_contac,
                  },
                  success: function (response) {
                    // console.log("2.5. crear cliente", response);
                    validarNoOperacion(nooperacion, entidadOpe)
                      .then(resolve)
                      .catch(reject);
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                    var errorMessage = "Error al crear cliente";
                    if (jqXHR.responseText) {
                      swal(
                        "Error: \n Error al crear cliente " +
                          cccliente +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      );
                    }
                    reject(errorMessage);
                  },
                });
              } catch (error) {
                reject(
                  swal(
                    "Error: \n Error al obtener el id de la entidad o id del asesor  en la linea " +
                      progresoActual +
                      "\n" +
                      "error"
                  )
                );
              }
            });
          }

          function identidad(entidad) {
            // console.log("identidad: ", entidad);
            return new Promise(function (resolve, reject) {
              $.post(
                "../../controller/entidad.php?op=identidad",
                { entidad: entidad },
                function (data) {
                  try {
                    data = JSON.parse(data);
                    ident = data[0].ent_id;
                    resolve();
                  } catch (error) {
                    // console.log("error");
                    reject(
                      swal(
                        "Error: \n Error al buscar el id de la entidad " +
                          entidad +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      )
                    );
                  }
                }
              );
            });
          }

          function idasesor(asesor) {
            // console.log("idasesor: ", asesor);
            return new Promise(function (resolve, reject) {
              $.post(
                "../../controller/usuario.php?op=idasesor",
                { asesor: asesor },
                function (data) {
                  try {
                    data = JSON.parse(data);
                    idase = data[0].usu_id;
                    resolve();
                  } catch (error) {
                    reject(
                      swal(
                        "Error: \n Error al buscar el id del asesor " +
                          asesor +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      )
                    );
                  }
                }
              );
            });
          }

          function editarCliente(cccliente) {
            // console.log("2.2. Editar cliente: ", cccliente);
            var estado = datos[6];
            var festado = moment().format("YYYY-MM-DD");

            return new Promise(function (resolve, reject) {
              $.ajax({
                type: "POST",
                url: "../../controller/cliente.php?op=editarclientexdoc",
                data: {
                  cccliente: cccliente,
                  estado: estado,
                  festado: festado,
                },
                success: function (response) {
                  // console.log("2.2. editar cliente", response);
                  validarNoOperacion(nooperacion, entidadOpe)
                    .then(resolve)
                    .catch(reject);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  var errorMessage = "Error al editar cliente";
                  if (jqXHR.responseText) {
                    swal(
                      "Error: \n Error al editar cliente " +
                        cccliente +
                        " en la linea " +
                        progresoActual +
                        "\n" +
                        "error"
                    );
                  }
                  reject(errorMessage);
                },
              });
            });
          }

          function validarNoOperacion(nooperacion, entidadOpe) {
            // console.log("3. validar nooperacion: ", nooperacion, entidadOpe);
            return new Promise(function (resolve, reject) {
              if (!nooperacion.trim()) {
                // reject("El campo nooperacion está vacío.");
                resolve();
                // return;
              } else {
                $.ajax({
                  type: "POST",
                  url: "../../controller/operacion.php?op=bopexno",
                  data: { noope: nooperacion, ident: entidadOpe },
                  success: function (response) {
                    // console.log("3. valiar no ope", response);
                    var data = JSON.parse(response);
                    var existeope = data[0]["cuenta"];

                    if (existeope == 0) {
                      // Usuario no existe, lo creamos
                      crearOperacion(nooperacion).then(resolve).catch(reject);
                    } else {
                      editaroperacion(nooperacion).then(resolve).catch(reject);
                    }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                    var errorMessage = "Error al validar operacion";
                    if (jqXHR.responseText) {
                      swal(
                        "Error: \n Error al validar operacion No. " +
                          nooperacion +
                          " de la entidad " +
                          entidadOpe +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      );
                    }
                    reject(errorMessage);
                  },
                });
              }
            });
          }

          function crearOperacion(nooperacion) {
            // console.log("3.1. Crear operacion: ", nooperacion);
            return new Promise(async function (resolve, reject) {
              var operacion = datos[11];

              monto = datos[13];
              if (monto === "") {
                monto = 0;
              } else {
                monto = monto.replace(/[$,.']/g, "");
              }

              var maprobado = datos[14];
              if (maprobado === "") {
                maprobado = 0;
              } else {
                maprobado = maprobado.replace(/[$,.']/g, "");
              }

              var plazo = datos[15];
              if (plazo === "") {
                plazo = 0;
              } else {
                plazo = plazo.replace(/\D/g, "");
              }

              var fcreacion = datos[17];
              if (moment(fcreacion, "D/MM/YYYY", true).isValid()) {
                fcreacion = moment(fcreacion, "DD/MM/YYYY").format(
                  "YYYY-MM-DD"
                );
              } else {
                fcreacion = moment().format("YYYY-MM-DD");
              }

              var festado = datos[18];
              if (moment(festado, "D/MM/YYYY", true).isValid()) {
                festado = moment(festado, "DD/MM/YYYY").format("YYYY-MM-DD");
              } else {
                festado = moment().format("YYYY-MM-DD");
              }
              var estadoOP = datos[16];
              var entidad = datos[12];

              try {
                await identidad(entidadOpe);
                await idcliente(cccliente);
                await estadocrm(estadoOP, entidadOpe);
                // console.log(estadoCRM);

                var fcierre = datos[19];
                if (
                  moment(fcierre, "DD/MM/YYYY", true).isValid() &&
                  estadoCRM === "Legalizacion"
                ) {
                  fcierre = moment(fcierre, "DD/MM/YYYY").format("YYYY-MM-DD");
                } else if (estadoCRM === "Legalizacion") {
                  fcierre = moment().format("YYYY-MM-DD");
                } else {
                  fcierre = "0000-00-00";
                }

                $.ajax({
                  type: "POST",
                  url: "../../controller/operacion.php?op=insert_ope",
                  data: {
                    ope_numero: nooperacion,
                    ope_operacion: operacion,
                    ope_entidad: ident,
                    ope_monto: monto,
                    ope_maprobado: maprobado,
                    ope_plazo: plazo,
                    ope_estadoOP: estadoOP,
                    ope_estado: estadoCRM,
                    ope_festado: festado,
                    ope_fcierre: fcierre,
                    ope_fcreacion: fcreacion,
                    id_cli: idcli,
                  },
                  success: function (response) {
                    // console.log("3.1. crear operacion", response);
                    resolve();
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                    var errorMessage = "Error al crear operación";
                    if (jqXHR.responseText) {
                      swal(
                        "Error: \n Error al crear operacion No. " +
                          nooperacion +
                          " de la entidad " +
                          entidadOpe +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      );
                    }
                    reject(errorMessage);
                  },
                });
              } catch (error) {
                reject("Error al crear operacion");
              }
            });
          }

          function estadocrm(estadoOP, entidadOpe) {
            // console.log("estadocrm: ", estadoOP, " y entidad: ", entidadOpe);
            return new Promise(function (resolve, reject) {
              $.post(
                "../../controller/estadosent.php?op=obtenerestadoCRM",
                { entidad: entidadOpe, estado: estadoOP },
                function (data) {
                  // console.log("estado crm buscar;", data);
                  try {
                    data = JSON.parse(data);
                    if (data[0].hasOwnProperty("est_crm") && data != []) {
                      estadoCRM = data[0].est_crm;
                      resolve();
                    } else {
                      estadoCRM = "Sin estado";
                      // console.log(estadoCRM);
                      resolve();
                    }
                  } catch (error) {
                    swal(
                      "Error: \n Error al buscar el estado " +
                        estadoOP +
                        " en la linea " +
                        progresoActual +
                        "\n" +
                        "error"
                    );
                  }
                }
              );
            });
          }

          function editaroperacion(nooperacion) {
            // console.log("3.2. editaroperacion: ", nooperacion);
            return new Promise(async function (resolve, reject) {
              var operacion = datos[11];
              var monto = datos[13];
              if (monto === "") {
                monto = 0;
              } else {
                monto = monto.replace(/[$,.']/g, "");
              }

              var maprobado = datos[14];
              if (maprobado === "") {
                maprobado = 0;
              } else {
                maprobado = monto.replace(/[$,.']/g, "");
              }

              var plazo = datos[15];
              if (plazo === "") {
                plazo = 0;
              } else {
                plazo = plazo.replace(/\D/g, "");
              }

              var festado = datos[18];
              if (moment(festado, "D/MM/YYYY", true).isValid()) {
                festado = moment(festado, "DD/MM/YYYY").format("YYYY-MM-DD");
              } else {
                festado = moment().format("YYYY-MM-DD");
              }

              var fcreacion = datos[17];
              if (moment(fcreacion, "D/MM/YYYY", true).isValid()) {
                fcreacion = moment(fcreacion, "DD/MM/YYYY").format(
                  "YYYY-MM-DD"
                );
              } else {
                fcreacion = moment().format("YYYY-MM-DD");
              }

              var estadoOP = datos[16];
              var entidad = datos[12];

              try {
                await idcliente(cccliente);
                await identidad(entidadOpe);
                await estadocrm(estadoOP, entidadOpe);
                await idoperacio(nooperacion, ident);
                var fcierre = datos[19];
                if (
                  moment(fcierre, "DD/MM/YYYY", true).isValid() &&
                  estadoCRM === "Legalizacion"
                ) {
                  fcierre = moment(fcierre, "DD/MM/YYYY").format("YYYY-MM-DD");
                } else if (estadoCRM === "Legalizacion") {
                  fcierre = moment().format("YYYY-MM-DD");
                } else {
                  fcierre = "0000-00-00";
                }

                $.ajax({
                  type: "POST",
                  url: "../../controller/operacion.php?op=editar_ope",
                  data: {
                    ope_id: idope,
                    ope_numero: nooperacion,
                    ope_operacion: operacion,
                    ope_entidad: ident,
                    ope_monto: monto,
                    ope_maprobado: maprobado,
                    ope_plazo: plazo,
                    ope_estadoOP: estadoOP,
                    ope_estado: estadoCRM,
                    ope_festado: festado,
                    ope_fcierre: fcierre,
                    id_cli: idcli,
                    fcreacion: fcreacion,
                  },
                  success: function (response) {
                    // console.log("3.2. editar operacion", response);
                    resolve();
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                    var errorMessage = "Error al editar operacion";
                    if (jqXHR.responseText) {
                      swal(
                        "Error: \n Error al editar operacion No. " +
                          nooperacion +
                          " de la entidad " +
                          entidadOpe +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      );
                    }
                    reject(errorMessage);
                  },
                });
              } catch (error) {}
            });
          }

          function idcliente(cccliente) {
            cccliente = cccliente.replace(/\./g, "");
            // console.log("idcliente: ", cccliente);
            return new Promise(function (resolve, reject) {
              $.post(
                "../../controller/cliente.php?op=Buscaridcli",
                { documento: cccliente },
                function (data) {
                  try {
                    data = JSON.parse(data);
                    idcli = data[0].cli_id;
                    resolve();
                  } catch (error) {
                    ("error");
                    reject(
                      swal(
                        "Error: \n Error al buscar el id del cliente " +
                          cccliente +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      )
                    );
                  }
                }
              );
            });
          }

          function idoperacio(nooperacion, ent) {
            // console.log("idoperacion: ", nooperacion, " y entidad", ent);
            return new Promise(function (resolve, reject) {
              $.post(
                "../../controller/operacion.php?op=idoperacion",
                { nooperacion: nooperacion, ident: ent },
                function (data) {
                  // console.log("id operacion;", data);

                  try {
                    data = JSON.parse(data);
                    idope = data[0].ope_id;
                    resolve();
                  } catch (error) {
                    reject(
                      swal(
                        "Error: \n Error al buscar el id de la operacion no. " +
                          nooperacion +
                          " de la entidad:  " +
                          entidadOpe +
                          " en la linea " +
                          progresoActual +
                          "\n" +
                          "error"
                      )
                    );
                  }
                }
              ).fail(function () {
                reject("Error en la solicitud al servidor");
              });
            });
          }

          // Procesar cada línea en secuencia
          lineas.reduce(function (promise, linea, indice) {
            return promise.then(function () {
              return procesarLinea(linea, indice);
            });
          }, Promise.resolve());
        };

        reader.readAsText(file);
      }
    } else {
      swal("Error", "No se ha seleccionado ningún archivo.", "error");
    }
  });
});

init();
