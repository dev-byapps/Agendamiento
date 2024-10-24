var tabla;
var vacios;

function init() {
  $("#campana_form").on("submit", function (e) {
    e.preventDefault();

    var estado = $("#cam_est").val();

    if(estado == 1){
      var fefinal = $("#fec_fin").val(); // Formato dd/mm/yyyy
      // Separar la fecha por "/"
      var partesFecha = fefinal.split("/"); 
      // Reordenar la fecha en formato yyyy/mm/dd
      var fechaFormateada = `${partesFecha[2]}/${partesFecha[1]}/${partesFecha[0]}`;
      // Obtener la fecha de hoy
      var hoy = new Date().toISOString().split('T')[0].replace(/-/g, '/');

      if(vacios <= 0){
        swal(
          {
            title: "BYAPPS::CRM",
            text: "No puede cambiar el estado ya que no hay registros por llamar.",
            type: "error",
            confirmButtonText: "OK",
          });
          return false; // Detener ejecución
      }
  
      if(fechaFormateada <= hoy){        
        // La fecha final es menor a hoy
      swal(
        {
          title: "BYAPPS::CRM",
          text: "La fecha final es menor a la fecha actual. Modifica la fecha.",
          type: "error",
          confirmButtonText: "OK",
        });
        return false; // Detener ejecución
      }else{
        guardaryeditar();
      }
    }
    else if(estado == 4){
      swal(
        {
          title: "BYAPPS::CRM",
          text: "¿Esta seguro de Cerrar esta campaña?, Recuerde que al cerrarla se cerraran las agendas activas",
          type: "error",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Si",
          cancelButtonText: "No",
          closeOnConfirm: false,
        },
        function (isConfirm) {
          if (isConfirm) {
            guardaryeditar();
          }
        }
      );
    }        
    else{
      guardaryeditar();
    }
  });
}
$(document).ready(function () {
  listar();
});
$(document).on("click", "#btnnuevo", function () {
  $("#cam_nom").prop("disabled", false);
    $("#fec_ini").prop("disabled", false);
    $("#fec_fin").prop("disabled", false);
    $("#hora_ini").prop("disabled", false);
    $("#hora_fin").prop("disabled", false);
    $("#grupocc").prop("disabled", false);
    $("#cam_int").prop("disabled", false);
    $("#cam_coment").prop("disabled", false);
    
  $("#cuenta").hide();
  $("#agente_vacios").hide();

  // Eliminar todas las opciones y agregar solo la opción "Inactiva"
  $("#cam_est").empty().append(new Option("Inactiva", 2));

  get_grupocc();
  $("#cam_id").val("");
  $("#mdltitulo").html("Nueva Campaña");
  $("#campana_form")[0].reset();
  $("#cam_est").prop("disabled", true);

  // Mostrar el modal
  $("#modalmantenimiento").modal("show");
});
function listar() {
  console.log("hola");
  tabla = $("#campana_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: true,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/campana.php?op=listar",
        type: "post",
        dataType: "json",
        error: function (e) {
          swal("Error", e.responseText, "error");
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
function editar(
  cam_id,
  nom,
  fini,
  ffin,
  hini,
  hfin,
  est,
  com,
  int,
  gcc,
  agent
) {
    $("#guardar").prop("disabled", true);

    $("#mdltitulo").html("Editar Campaña");
    $("#cuenta").text("Contactos Registrados: ");
    $("#cuenta").show();
    $("#agente_vacios").text("Contactos por llamar: ");
    $("#agente_vacios").show();


    $("#cam_nom").prop("disabled", false);
    $("#fec_ini").prop("disabled", false);
    $("#fec_fin").prop("disabled", false);
    $("#hora_ini").prop("disabled", false);
    $("#hora_fin").prop("disabled", false);
    $("#grupocc").prop("disabled", false);
    $("#cam_int").prop("disabled", false);
    $("#cam_coment").prop("disabled", false);
    $("#cam_est").prop("disabled", false);

    // Llamar a la función para obtener el grupo
    get_grupocc();

    if(est == 1){
      // Eliminar todas las opciones y agregar solo la opción necesarias
      $("#cam_est").empty()
      .append(new Option("Activa", 1))
      .append(new Option("Inactiva", 2))
      .append(new Option("Cierre completo", 4));
      $("#cam_est").val(est);

    }
    else if(est == 2){
      if (agent == 0 || agent == "0") {
        $("#cam_est").prop("disabled", true);
        $("#cam_est").empty()
          .append(new Option("Inactiva", 2));
        $("#cam_est").val(est);
      } else {
        $("#cam_est").prop("disabled", false);
        $("#cam_est").empty()
          .append(new Option("Activa", 1))
          .append(new Option("Inactiva", 2))
          .append(new Option("Cierre completo", 4));
        $("#cam_est").val(est);
      }
    }
    else if(est == 3){
      $("#cam_est").empty()
      .append(new Option("Activa", 1))
      .append(new Option("Completada", 3))
      .append(new Option("Cierre completo", 4));
      $("#cam_est").val(est);
    }
    else if(est == 4){
      $("#cam_est").empty().append(new Option("Cierre completo", 4));
      $("#cam_est").val(est);

      $("#cam_nom").prop("disabled", true);
      $("#fec_ini").prop("disabled", true);
      $("#fec_fin").prop("disabled", true);
      $("#hora_ini").prop("disabled", true);
      $("#hora_fin").prop("disabled", true);
      $("#grupocc").prop("disabled", true);
      $("#cam_int").prop("disabled", true);
      $("#cam_coment").prop("disabled", true);

    }
    else if(est == 5){
      $("#cam_est").empty()      
      .append(new Option("Cierre completo", 4))
      .append(new Option("Terminada", 5));
      $("#cam_est").val(est);
    }

      // Establecer los valores del formulario
      $("#cam_id").val(cam_id);
      $("#cam_nom").val(nom);
      $("#fec_ini").val(fini);
      $("#fec_fin").val(ffin);
      $("#hora_ini").val(hini);
      $("#hora_fin").val(hfin);
      $("#grupocc").val(gcc);
      $("#cam_int").val(int);
      $("#cam_coment").val(com);

      // Contactos
      $.post(
        "../../controller/llamada.php?op=contactos",
        { cam_id: cam_id },
        function (data) {
          data = JSON.parse(data);

          // Acceder a los valores devueltos por el backend
          var contactos = data["Tcount"]; // Total de contactos
          vacios = data["vacios"]; // Contactos con el campo AGENTE vacío

          if (contactos > 0) {
            $("#cuenta").text("Contactos Registrados: " + contactos);
          } else if (contactos === 0) {
            $("#cuenta").text("No has agregado ningún dato en esta campaña");
          } else {
            $("#cuenta").text("No has agregado ningún dato en esta campaña");
          }

           // Mostrar también el número de registros con AGENTE vacío
          if (vacios > 0) {
              $("#agente_vacios").text("Contactos por llamar: " + vacios);
          } else {
              $("#agente_vacios").text("No hay contactos por llamar.");
          }

          // Habilitar el botón "Guardar" después de procesar los datos
          $("#guardar").prop("disabled", false);
        }
      );

  // Mostrar el modal después de que se hayan procesado los datos de contactos
  $("#modalmantenimiento").modal("show");
}
function inactivos() {
  tabla = $("#campana_data")
    .dataTable({
      aProcessing: true,
      aServerSide: true,
      searching: false,
      lengthChange: false,
      colReorder: true,
      ajax: {
        url: "../../controller/campana.php?op=listarInactivos",
        type: "post",
        dataType: "json",
        error: function (e) {
          swal("Error", e.responseText, "error");
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
function get_grupocc() {
  $.post("../../controller/grupocc.php?op=get", function (data) {
    $("#grupocc").empty();
    $("#grupocc").html(data);
  });
}
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
    $button.html('<i class="fa fa-trash"></i>&nbsp;Cerrados');
    listar();
  }
});
function eliminar(cam_id) {
  swal(
    {
      title: "BYAPPS::CRM",
      text: "Esta seguro de Eliminar definitivamente el registro?",
      type: "error",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: false,
    },
    function (isConfirm) {
        swal(
          {
            title: "BYAPPS::CRM",
            text: "Se eliminaran todos los registros que pertenezcan a esta campaña. Esta seguro de Eliminar definitivamente el registro?",
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
                "../../controller/campana.php?op=eliminardef",
                { cam_id: cam_id },
                function (data) {}
              );
      
              $("#campana_data").DataTable().ajax.reload();
      
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
  );
}
function guardaryeditar() {
  var formData = new FormData($("#campana_form")[0]);
  formData.append("hora_ini", $("#hora_ini").val());
  formData.append("hora_fin", $("#hora_fin").val());
  formData.append("cam_est", $("#cam_est").val());

  $.ajax({
    url: "../../controller/campana.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      if (datos == "1") {
        $("#campana_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#campana_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Registrado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } else if (datos == "2") {
        $("#campana_form")[0].reset();
        /* TODO:Ocultar Modal */
        $("#modalmantenimiento").modal("hide");
        $("#campana_data").DataTable().ajax.reload();

        /* TODO:Mensaje de Confirmacion */
        swal({
          title: "BYAPPS::CRM",
          text: "Actualizado Correctamente.",
          type: "success",
          confirmButtonClass: "btn-success",
        });
      } 
    },
  });
}
function leerArchivo(cam_id) {
  var input = document.getElementById("fileInput_" + cam_id);
  var file = input.files[0];

  if (file) {
    $("#barraP").show();

    var reader = new FileReader();

    reader.onload = function (e) {
      var lineas = e.target.result.split("\n");
      var totalClientes = lineas.length - 2;
      var progresoActual = 0;

      $("#total_clientes").text(totalClientes);

      var primeraLinea = lineas[0].split(";").map(function (columna) {
        return columna.trim();
      });

      // Identificar todas las columnas (estándar y adicionales)
      var columnas = primeraLinea.filter(function (columna) {
        return columna !== "";
      });

      // Función para validar si un valor es una fecha en formato D/M/AAAA o D-M-AAAA
      function esFecha(valor) {
        var regexFecha = /^\d{1,2}[\/-]\d{1,2}[\/-]\d{2,4}$/;
        return regexFecha.test(valor);
      }

      // Función para convertir la fecha al formato YYYY-MM-DD
      function convertirFecha(valor) {
        var fechaParts = valor.split(/[\/-]/); // Divide por / o -
        if (fechaParts.length === 3) {
          var dia = fechaParts[0].padStart(2, "0");
          var mes = fechaParts[1].padStart(2, "0");
          var anio =
            fechaParts[2].length === 2 ? "20" + fechaParts[2] : fechaParts[2];
          return anio + "-" + mes + "-" + dia;
        }
        return valor;
      }

      // Función para limpiar y convertir valores de moneda
      function limpiarMoneda(valor) {
        // Eliminar símbolo de moneda y separadores de miles
        return valor.replace(/[^\d.-]/g, "");
      }

      // Primero, envía las columnas adicionales
      var formData = new FormData();
      formData.append("cam_id", cam_id);
      columnas.forEach(function (columna) {
        formData.append("columnasAdicionales[]", columna);
      });

      $.ajax({
        type: "POST",
        url: "../../controller/campana.php?op=columnas",
        data: formData,
        contentType: false,
        processData: false,
        success: function (e) {
          // Después de que se han enviado las columnas adicionales, envía los datos del archivo
          lineas.forEach(function (linea, indice) {
            if (indice === 0) return; // Omitir la primera línea del archivo CSV

            try {
              var datos = linea.split(";");
              if (datos.length >= 3) {
                var dataObj = {
                  cam_id: cam_id,
                };

                // Agregar datos de todas las columnas
                columnas.forEach(function (columna, colIndex) {
                  var valor = datos[colIndex].trim();

                  // Si la columna contiene una fecha, convertir el formato de la fecha
                  if (esFecha(valor)) {
                    valor = convertirFecha(valor);
                  }

                  // Si la columna contiene un valor de moneda, limpiarlo
                  if (valor.startsWith("$")) {
                    valor = limpiarMoneda(valor);
                  }

                  dataObj[columna.toLowerCase()] = valor;
                });

                $.ajax({
                  type: "POST",
                  url: "../../controller/llamada.php?op=subirdatos",
                  data: dataObj,
                  success: function (response) {
                    progresoActual++;
                    $("#progreso_actual").text(progresoActual);
                    var porcentaje = (progresoActual / totalClientes) * 100;
                    $("#progreso").val(porcentaje.toFixed(2));
                    if (progresoActual === totalClientes) {
                      $("#completado").text("Carga completada");
                      swal(
                        {
                          title: "BYAPPS::CRM",
                          text: "Campaña cargada. ¿Deseas activar la campaña?",
                          type: "warning",
                          showCancelButton: true,
                          confirmButtonClass: "btn-success",
                          cancelButtonClass: "btn-danger",
                          confirmButtonText: "Sí, activar",
                          cancelButtonText: "No, gracias",
                          closeOnConfirm: false,
                          closeOnCancel: false,
                        },
                        function (isConfirm) {
                          if (isConfirm) {
                            // Llamar a la función para cambiar el estado de la campaña
                            cambiarestado(cam_id);
                          } else {
                            swal(
                              "Cancelado",
                              "La campaña no ha sido activada.",
                              "error"
                            );
                          }
                          // Reiniciar la barra de progreso y los textos
                          setTimeout(function () {
                            $("#barraP").hide();
                            $("#completado").text("");
                            $("#progreso").val(0);
                            $("#progreso_actual").text("0");
                            $("#total_clientes").text("0");
                            swal.close();
                          }, 5000);
                        }
                      );
                    }
                  },
                  error: function (xhr, status, error) {
                    var mensajeError =
                      "Error en la línea " +
                      indice +
                      ": " +
                      error +
                      " - Cédula: " +
                      (icc != -1 ? datos[icc] : "N/A");
                    swal("Error", mensajeError, "error");
                  },
                });
              }
            } catch (ex) {
              var mensajeError =
                "Error en la línea " + indice + ": " + ex.message;
              swal("Error", mensajeError, "error");
            }
          });
        },
        error: function (xhr, status, error) {
          swal("Error", error, "error");
        },
      });
    };

    reader.readAsText(file);
    // Reiniciar el input del archivo después de leerlo
    input.value = "";
  }
}
$(document).on("click", "#c", function () {
  const dcamp = $(this).data("datocamp");
  // Divide dcamp en partes separadas por '|'
  const parts = dcamp.split("|");
  // Extrae los valores de textocifrado y cam_nom
  const textocifrado = parts[0];
  const cam_nom = parts[1];
  // Puedes usar textocifrado y cam_nom según lo necesites
  var queryParams = `?c=${textocifrado}&n=${cam_nom}`;
  var href = "../cargarbase/" + queryParams;
  window.location.href = href;
});
function cambiarestado(cam_id) {
  $.ajax({
    type: "POST",
    url: "../../controller/campana.php?op=cambiarestado",
    data: { cam_id: cam_id },
    success: function (response) {
      $("#campana_data").DataTable().ajax.reload();
      swal("Activada", "La campaña ha sido activada exitosamente.", "success");      
    },
    error: function (xhr, status, error) {
      swal("Error", "Hubo un problema al activar la campaña.", "error");
    },
  });
}

init();
