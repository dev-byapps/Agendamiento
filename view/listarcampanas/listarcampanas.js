var contactoss = 0;
var campanaId;
var num = 0;
var nombrevariable = "contactos" + num;
var nombrevarid = num;

function init() {
  listarcampanas();
}

function listarcampanas() {
  var usuid = usu_id;

  function handleNoData() {
    $("#container").html(
      '<br><br><p style="text-align: center;"><img src="../../public/img/nocamp.png"><br><br><font style="font-size: 2rem; font-weight: 300; vertical-align: inherit;">No hay campañas disponibles</font></p>'
    );
  }

  function handleError() {
    $("#container").html(
      '<br><br><p style="text-align: center;"><img src="../../public/img/nocamp.png"><br><br><font style="font-size: 2rem; font-weight: 300; vertical-align: inherit;">Error al cargar las campañas</font></p>'
    );
  }

  if (
    usuPerfil == "Administrador" ||
    usuPerfil == "Gerencia" ||
    usuPerfil == "Operativo"
  ) {
    $.ajax({
      url: "../../controller/campana.php?op=campanasAdmin",
      type: "POST",
      data: {},
      success: function (datos) {
        var data = JSON.parse(datos);

        if (
          !Array.isArray(data) || // Asegúrate de que data sea un array
          data.length === 0 || // Verifica si el array está vacío
          (data.length === 1 && Array.isArray(data[0]) && data[0].length === 0) // Verifica si el primer elemento es un array vacío
        ) {
          handleError();
          return; // Detener el proceso si no es un JSON válido
        }

        if (!Array.isArray(data) || data.length === 0 || !data[0].cam_id) {
          handleNoData();
          return; // Detener el proceso si no hay datos válidos
        }

        var container = $("#container");
        container.empty();
        data.forEach(function (campana) {
          var estado;
          var clase;
          var clasebtn;
          var campanaId = campana.cam_id;
          var variableid = {};
          variableid[nombrevarid] = campanaId;
          var campanaName = campana.cam_nom;
          var horaInicio = campana.cam_hoini.replace(/:00$/, "");
          var horaFinal = campana.cam_hofin.replace(/:00$/, "");
          var now = new Date();
          var horaActual =
            now.getHours().toString().padStart(2, "0") +
            ":" +
            now.getMinutes().toString().padStart(2, "0");
          if (horaActual >= horaInicio && horaActual <= horaFinal) {
            estado = "Activo";
            clase = "label label-pill label-success";
            clasebtn = "btn btn-rounded";
          } else {
            estado = "Bloqueado";
            clase = "label label-pill label-secondary";
            clasebtn = "btn btn-rounded btn-secondary ";
          }

          $.ajax({
            url: "../../controller/llamada.php?op=bllamada",
            type: "POST",
            data: { camp_id: campanaId },
            success: function (datos) {
              var data = JSON.parse(datos);
              var contactoss = data[0]["@cantidadSinAgente"];
              var variable = {};
              variable[nombrevariable] = contactoss;
              num += 1;

              // Crear el div para cada campana
              var div = $("<div>", {
                class:
                  "col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch mb-4",
              });

              var article = $("<article>", {
                class: "card-user box-typical d-flex flex-column",
                style:
                  "text-align: center; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);",
              });

              var btn = $("<a>", {
                href: "#",
                class: `btn ${clasebtn} ${
                  estado === "Bloqueado" ? "disabled" : ""
                }`,
                text: "Iniciar",
                "data-id": variableid[nombrevarid],
                style: "display: inline-block; margin-top: 10px;", // BotÃ³n centrado
              });

              // Deshabilitar el botÃ³n
              if (estado === "Bloqueado") {
                btn.click(function (event) {
                  event.preventDefault(); // Prevenir la acciÃ³n predeterminada del enlace
                });
              }

              // Manejar el clic del botÃ³n
              btn.click(function () {
                if (!$(this).hasClass("disabled")) {
                  var detalle = "CONSOLA";
                  var estado = 1;
                  //reconsola
                  $.post(
                    "../../controller/reconsola.php?op=registrar",
                    { campid: campanaId, detalle: detalle, estado: estado },
                    function (data, status) {
                      var queryParams = `?cam=${variableid[nombrevarid]}`;
                      var href = "../consola/" + queryParams;
                      window.location.href = href;
                    }
                  );
                }
              });

              // Crear el div y la imagen con estilos en lÃ­nea
              var photoDiv = $("<div>", {
                class: "card-user-photo mb-2",
                style: "display: flex; justify-content: center; padding: 10px;",
              }).append(
                $("<img>", {
                  src: "../../public/img/photo-184-1.jpg",
                  alt: "User Photo",
                  class: "img-fluid",
                  style: "max-width: 100%; height: auto;",
                })
              );

              var estadoDiv = $("<div>", {
                class: "card-user-action mb-2",
                style: "width: 100%; text-align: left; padding: 10px;",
              }).append(
                $("<span>", {
                  class: `badge ${clase}`,
                  text: estado,
                })
              );

              article.append(
                estadoDiv, // Estado alineado a la izquierda
                photoDiv, // Imagen centrada
                $("<div>", {
                  class: "card-user-name mb-2",
                  text: campanaName,
                }),
                $("<div>", {
                  class: "card-user-status mb-2",
                  id: "contac" + num,
                  text: variable[nombrevariable] + " contactos por llamar",
                }),
                $("<div>", {
                  class: "card-user-status mb-2",
                  text: horaInicio + " - " + horaFinal,
                }),
                btn // BotÃ³n centrado
              );

              div.append(article);
              container.append(div);
            },
          });
        });
      },
    });
  } else {
    $.ajax({
      url: "../../controller/campana.php?op=campanasActivas",
      type: "POST",
      data: { usu_id: usuid },
      success: function (datos) {
          try {
              var data = JSON.parse(datos);
  
              // Verifica que data sea un array y no esté vacío
              if (!Array.isArray(data) || data.length === 0) {
                  handleError(); // Función para manejar errores o ausencia de datos
                  return;
              }
  
              var container = $("#container");
              container.empty(); // Limpia el contenedor antes de agregar nuevos elementos
  
              data.forEach(function (item, index) {
                  // Verifica que el objeto tenga las propiedades necesarias
                  if (!item.cam_id || !item.cam_nom) {
                      // Si falta alguna propiedad, lo saltamos
                      return;
                  }
  
                  var campanaId = item.cam_id;
                  var campanaName = item.cam_nom;
                  var horaInicio = item.hora_ini.replace(/:00$/, "");
                  var horaFinal = item.hora_fin.replace(/:00$/, "");
  
                  // Lógica para determinar el estado y clases CSS
                  var now = new Date();
                  var horaActual = now.toTimeString().split(" ")[0];
                  var estado, clase, clasebtn;
  
                  if (horaActual >= horaInicio && horaActual <= horaFinal) {
                      estado = "Activo";
                      clase = "badge badge-pill badge-success";
                      clasebtn = "btn btn-rounded btn-primary";
                  } else {
                      estado = "Bloqueado";
                      clase = "badge badge-pill badge-secondary";
                      clasebtn = "btn btn-rounded btn-secondary disabled";
                  }
  
                  // Realiza una segunda llamada AJAX para obtener la cantidad de contactos
                  $.ajax({
                      url: "../../controller/llamada.php?op=bllamada",
                      type: "POST",
                      data: { camp_id: campanaId },
                      success: function (dataLlamada) {
                          try {
                              var llamadaData = JSON.parse(dataLlamada);
                              var contactos = llamadaData[0]["@cantidadSinAgente"] || 0;
  
                              // Crear el div para cada campaña
                              var div = $("<div>", {
                                  class: "col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch mb-4",
                              });
  
                              var article = $("<article>", {
                                  class: "card-user box-typical d-flex flex-column",
                                  style: "text-align: center; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);",
                              });
  
                              var btn = $("<a>", {
                                  href: "#",
                                  class: clasebtn,
                                  text: "Iniciar",
                                  "data-id": campanaId,
                                  style: "display: inline-block; margin-top: 10px;", // Botón centrado
                              });
  
                              // Manejar el clic del botón
                              btn.click(function (event) {
                                  if (!$(this).hasClass("disabled")) {
                                      event.preventDefault(); // Prevenir la acción predeterminada
                                      var detalle = "CONSOLA";
                                      var estadoRegistro = 1;
  
                                      $.post(
                                          "../../controller/reconsola.php?op=registrar",
                                          { campid: campanaId, detalle: detalle, estado: estadoRegistro },
                                          function (dataReconsola, status) {
                                              console.log(campanaId);
                                              // Puedes agregar lógica adicional aquí, como redireccionar
                                              var queryParams = `?cam=${campanaId}`;
                                              var href = "../consola/" + queryParams;
                                              window.location.href = href;

                                          }
                                      );
                                  }
                              });
  
                              // Crear el div y la imagen con estilos en línea
                              var photoDiv = $("<div>", {
                                  class: "card-user-photo mb-2",
                                  style: "display: flex; justify-content: center; padding: 10px;",
                              }).append(
                                  $("<img>", {
                                      src: "../../public/img/photo-184-1.jpg",
                                      alt: "User Photo",
                                      class: "img-fluid",
                                      style: "max-width: 100%; height: auto;",
                                  })
                              );
  
                              var estadoDiv = $("<div>", {
                                  class: "card-user-action mb-2",
                                  style: "width: 100%; text-align: left; padding: 10px;",
                              }).append(
                                  $("<span>", {
                                      class: clase,
                                      text: estado,
                                  })
                              );
  
                              // Agregar todos los elementos al artículo
                              article.append(
                                  estadoDiv, // Estado alineado a la izquierda
                                  photoDiv, // Imagen centrada
                                  $("<div>", {
                                      class: "card-user-name mb-2",
                                      text: campanaName,
                                  }),
                                  $("<div>", {
                                      class: "card-user-status mb-2",
                                      text: contactos + " contactos por llamar",
                                  }),
                                  $("<div>", {
                                      class: "card-user-status mb-2",
                                      text: horaInicio + " - " + horaFinal,
                                  }),
                                  btn // Botón centrado
                              );
  
                              div.append(article);
                              container.append(div);
                          } catch (e) {
                              console.error("Error al procesar la respuesta de llamada:", e);
                          }
                      },
                      error: function (jqXHR, textStatus, errorThrown) {
                          console.error("Error en la llamada AJAX de llamada.php:", textStatus, errorThrown);
                      }
                  });
              });
          } catch (e) {
              console.error("Error al procesar la respuesta de campanasActivas:", e);
              handleError();
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.error("Error en la llamada AJAX de campanasActivas:", textStatus, errorThrown);
          handleError();
      }
  });
  
  }
}

init();
