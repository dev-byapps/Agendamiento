$(document).ready(function () {
  let currentCell = null;
  const url = window.location.href;
  const params = new URLSearchParams(new URL(url).search);
  const tick_id = params.get("c");
  var cam_nom = params.get("n");
  const decoded_id = decodeURIComponent(tick_id);
  var camp = decoded_id.replace(/\s/g, "+");

  $("#tlb_camp").text("Cargar Base " + cam_nom);

  // Función para manejar la tecla Tab
  $("#dynamicTable").on("keydown", "td", function (e) {
    if (e.which === 9) {
      e.preventDefault();
      const cell = $(this);
      const row = cell.closest("tr");
      const colIndex = cell.index();
      const nextCell = row.find("td").eq(colIndex + 1);
      nextCell.focus(); // Mover a la siguiente celda
    }
  });
  // Manejar la tecla Enter
  $(document).on("keydown", function (event) {
    if (event.which === 13) {
      // 13 es el código de la tecla Enter
      event.preventDefault();
    }
  });
  // Agregar columna
  $("#addColumn").on("click", function () {
    $("thead tr").append('<th contenteditable="true">Nueva Columna</th>');
    $("tbody tr").each(function () {
      $(this).append('<td contenteditable="true"></td>');
    });
  });
  // Eliminar columna seleccionada
  $("#removeColumn").on("click", function () {
    const index = $("#dynamicTable th.selected").index();
    const encabezadosNoEliminables = [
      "CÉDULA",
      "NOMBRE",
      "CONVENIO",
      "TELÉFONO",
      "CIUDAD",
    ];
    // Obtener el texto del encabezado seleccionado
    const textoEncabezado = $("#dynamicTable th.selected").text().toUpperCase();

    if (index > 0 && !encabezadosNoEliminables.includes(textoEncabezado)) {
      $("#dynamicTable tr").each(function () {
        $(this).find("td, th").eq(index).remove();
      });
    } else {
      swal("Error", "No se puede eliminar la columna seleccionada.", "error");
    }
  });
  // Agregar fila
  $("#addRow").on("click", function () {
    var table = $("#dynamicTable tbody");
    var rowCount = table.find("tr").length + 1;

    // Obtener la cantidad de columnas actuales en la tabla (incluyendo la columna de encabezado de fila)
    var colCount = $("#dynamicTable thead th").length;

    // Iniciar la fila con el número de la fila en la primera celda
    var newRow = `<tr><td class="row-header">${rowCount}</td>`;

    // Agregar las celdas editables en la nueva fila, según la cantidad de columnas
    for (var i = 1; i < colCount; i++) {
      newRow += '<td contenteditable="true"></td>';
    }

    // Cerrar la fila
    newRow += "</tr>";

    // Agregar la nueva fila a la tabla
    table.append(newRow);
  });
  // Eliminar fila seleccionada
  $("#removeRow").on("click", function () {
    $("#dynamicTable tbody tr.selected").each(function () {
      // Verificar si la fila seleccionada no es la primera fila (índice 0) ni la segunda fila (índice 1)
      if ($(this).index() !== 0) {
        $(this).remove();
        renumberRows();
      }
    });
  });
  // Manejar clic en celdas para seleccionar la celda actual
  $("#dynamicTable").on("click", "td", function () {
    currentCell = $(this);
    $("#dynamicTable .selected").removeClass("selected");
    $(this).addClass("selected");
  });
  // Manejar pegado de datos
  $("#dynamicTable").on("paste", function (e) {
    e.preventDefault();
    if (!currentCell) {
      swal("Error", "No hay ninguna celda seleccionada.", "error");
      return;
    }

    const clipboardData = (e.originalEvent || e).clipboardData;
    const pastedData = clipboardData.getData("text/plain");
    const rows = pastedData
      .split("\n")
      .map((row) => row.split("\t").map((cell) => cell.trim())); // Eliminar espacios en blanco

    // Insertar datos en la celda actual
    const startRowIndex = currentCell.closest("tr").index();
    const startColIndex = currentCell.index();

    rows.forEach((rowData, rowIndex) => {
      // Verificar si se necesita agregar una nueva fila
      let row = $("#dynamicTable tbody tr").eq(startRowIndex + rowIndex);
      if (row.length === 0) {
        // Solo agregar fila si hay datos para llenar
        if (rowData.some((cellData) => cellData !== "")) {
          $("#dynamicTable tbody").append("<tr></tr>");
          row = $("#dynamicTable tbody tr").eq(startRowIndex + rowIndex);
          row.append(
            '<td class="row-header">' + (startRowIndex + rowIndex + 1) + "</td>"
          );
          for (let j = 0; j < $("thead th").length - 1; j++) {
            row.append('<td contenteditable="true"></td>');
          }
        } else {
          return; // Si la fila no tiene datos, no hacer nada
        }
      }

      rowData.forEach((cellData, colIndex) => {
        const cell = row.find("td").eq(startColIndex + colIndex);
        if (cell.length > 0) {
          cell.text(cellData);
          cell.removeClass("error");

          // Validar según el encabezado
          const headerText = $("#dynamicTable thead th")
            .eq(startColIndex + colIndex)
            .text()
            .trim()
            .toUpperCase();

          const trimmedValue = cellData;

          if (headerText === "CÉDULA") {
            if (
              trimmedValue.length > 10 ||
              trimmedValue.length < 6 ||
              !/^\d+$/.test(trimmedValue) ||
              trimmedValue.length === 0
            ) {
              cell.addClass("error");
            }
          } else if (headerText === "NOMBRE") {
            if (
              !/^[a-zA-Z\s]*$/.test(trimmedValue) ||
              trimmedValue.length < 4
            ) {
              cell.addClass("error");
            }
          } else if (headerText === "TELÉFONO") {
            if (cellData.length !== 10 || !/^\d+$/.test(cellData)) {
              cell.addClass("error");
            }
          } else if (headerText === "TEL. ALTERNATIVO") {
            if (cellData !== "") {
              // Asegúrate de que la celda no esté vacía
              if (
                cellData.length !== 10 || // Verifica la longitud
                !/^\d+$/.test(cellData) // Verifica que sea numérico
              ) {
                cell.addClass("error");
              } else {
                cell.removeClass("error"); // Remueve la clase si los datos son válidos
              }
            } else {
              cell.removeClass("error"); // Asegúrate de remover la clase si la celda está vacía
            }
          } else if (headerText === "F. NACIMIENTO") {
            if (cellData !== "") {
              const dateFormats = [
                /^\d{2}\/\d{2}\/\d{4}$/, // DD/MM/YYYY
                /^\d{1}\/\d{1}\/\d{4}$/, // D/M/YYYY
                /^\d{1}\/\d{2}\/\d{4}$/, // D/MM/YYYY
                /^\d{2}\/\d{2}\/\d{2}$/, // DD/MM/YY
                /^\d{1}\/\d{1}\/\d{2}$/, // D/M/YY
                /^\d{2}-\d{2}-\d{4}$/, // DD-MM-YYYY
                /^\d{1}-\d{1}-\d{4}$/, // D-M-YYYY
                /^\d{1}-\d{2}-\d{4}$/, // D-MM-YYYY
                /^\d{2}-\d{2}-\d{2}$/, // DD-MM-YY
                /^\d{1}-\d{1}-\d{2}$/, // D-M-YY
              ];

              let isValid = false;
              let dateObject = null;

              for (const format of dateFormats) {
                if (format.test(cellData)) {
                  let parts;
                  if (cellData.includes("/")) {
                    parts = cellData.split("/");
                  } else {
                    parts = cellData.split("-");
                  }

                  if (parts[2].length === 2) {
                    if (
                      parseInt(parts[2], 10) >= 1 &&
                      parseInt(parts[2], 10) <= 24
                    ) {
                      parts[2] = "20" + parts[2];
                    } else {
                      parts[2] = "19" + parts[2];
                    }
                  }

                  const day = parseInt(parts[0], 10);
                  const month = parseInt(parts[1], 10);
                  const year = parseInt(parts[2], 10);

                  if (
                    year >= 1900 &&
                    year <= 2100 &&
                    month >= 1 &&
                    month <= 12
                  ) {
                    const date = new Date(year, month - 1, day);
                    if (
                      date.getFullYear() === year &&
                      date.getMonth() === month - 1 &&
                      date.getDate() === day
                    ) {
                      isValid = true;
                      dateObject = date;
                      break;
                    }
                  }
                }
              }
              if (!isValid) {
                cell.addClass("error");
              } else {
                // Convertir la fecha al formato YYYY-MM-DD
                const formattedDate = dateObject.toISOString().split("T")[0];

                cell.text(formattedDate);
                cell.removeClass("error");
              }
            } else {
              cell.removeClass("error"); // Asegúrate de remover la clase si la celda está vacía
            }
          } else if (headerText === "CIUDAD") {
            if (trimmedValue.length < 2) {
              cell.addClass("error");
            }
          }
        }
      });
    });

    renumberRows();
  });
  // Manejar edición manual de datos
  $("#dynamicTable").on("input", "td[contenteditable='true']", function () {
    const cell = $(this);
    const headerText = $("#dynamicTable thead th")
      .eq(cell.index())
      .text()
      .trim()
      .toUpperCase();
    const value = cell.text().trim();

    cell.removeClass("error");

    if (headerText === "CÉDULA") {
      if (
        value.length > 10 ||
        value.length < 6 ||
        !/^\d+$/.test(value) ||
        value.length === 0
      ) {
        cell.addClass("error");
      }
    } else if (headerText === "NOMBRE") {
      if (!/^[a-zA-Z\s]*$/.test(value)) {
        cell.addClass("error");
      }
    } else if (headerText === "TELÉFONO" || headerText === "TEL. ALTERNATIVO") {
      if (value.length !== 10 || !/^\d+$/.test(value)) {
        cell.addClass("error");
      }
    }
    // La validación de fecha se maneja en el evento blur
  });
  $("#dynamicTable").on("blur", "td[contenteditable='true']", function () {
    const cell = $(this);
    const headerText = $("#dynamicTable thead th")
      .eq(cell.index())
      .text()
      .trim()
      .toUpperCase();
    const value = cell.text().trim();

    if (headerText === "F. NACIMIENTO") {
      const dateFormats = [
        /^\d{2}\/\d{2}\/\d{4}$/, // DD/MM/YYYY
        /^\d{1}\/\d{1}\/\d{4}$/, // D/M/YYYY
        /^\d{1}\/\d{2}\/\d{4}$/, // D/MM/YYYY
        /^\d{2}\/\d{2}\/\d{2}$/, // DD/MM/YY
        /^\d{1}\/\d{1}\/\d{2}$/, // D/M/YY
        /^\d{2}-\d{2}-\d{4}$/, // DD-MM-YYYY
        /^\d{1}-\d{1}-\d{4}$/, // D-M-YYYY
        /^\d{1}-\d{2}-\d{4}$/, // D-MM-YYYY
        /^\d{2}-\d{2}-\d{2}$/, // DD-MM-YY
        /^\d{1}-\d{1}-\d{2}$/, // D-M-YY
      ];

      let formattedDate;
      let isValid = false;
      let dateObject = null;
      const dateFormatYMD = /^\d{4}-\d{2}-\d{2}$/;

      for (const format of dateFormats) {
        if (format.test(value)) {
          let parts;
          if (value.includes("/")) {
            parts = value.split("/");
          } else {
            parts = value.split("-");
          }
          if (parts[2].length === 2) {
            // Verificar si el año es un número entre 01 y 24
            if (parseInt(parts[2], 10) >= 1 && parseInt(parts[2], 10) <= 24) {
              // Si el año está en el rango 01 a 24, colocar "20"
              parts[2] = "20" + parts[2];
            } else {
              // De lo contrario, colocar "19"
              parts[2] = "19" + parts[2];
            }
          }

          const day = parseInt(parts[0], 10);
          const month = parseInt(parts[1], 10);
          const year = parseInt(parts[2], 10);

          if (year >= 1910 && year <= 2100 && month >= 1 && month <= 12) {
            const date = new Date(year, month - 1, day);
            const monthString = String(date.getMonth() + 1).padStart(2, "0"); // Mes va de 0 a 11
            const dayString = String(date.getDate()).padStart(2, "0");

            // Crear el formato yyyy-mm-dd
            formattedDate = `${year}-${monthString}-${dayString}`;

            if (
              date.getFullYear() === year &&
              date.getMonth() === month - 1 &&
              date.getDate() === day
            ) {
              isValid = true;
              dateObject = date;
              break;
            }
          }
        }
      }

      if (dateFormatYMD.test(value)) {
        isValid = "bien";
      }
      if (value === "") {
        isValid = "vacio";
      }

      if (!isValid) {
        cell.addClass("error");
      } else if (isValid == "bien") {
        cell.removeClass("error");
      } else if (isValid == true) {
        cell.text(formattedDate);
        cell.removeClass("error");
      } else if (isValid == "vacio") {
        cell.removeClass("error");
      }
    }
  });
  // Añadir estilo para la celda con error
  const style = `
    <style>
        .error {
            background-color:  #ffcccc !important;
            color: black !important;
        }
    </style>
`;
  $("head").append(style);
  // Numerar filas
  function renumberRows() {
    $("#dynamicTable tbody tr").each(function (index) {
      $(this)
        .find("td:first")
        .addClass("row-header")
        .text(index + 1);
    });
  }
  // Seleccionar fila o columna
  $("#dynamicTable").on("click", "td, th", function () {
    $("#dynamicTable .selected").removeClass("selected");
    if ($(this).hasClass("row-header")) {
      $(this).closest("tr").addClass("selected");
    } else if ($(this).closest("thead").length) {
      const index = $(this).index();
      $("#dynamicTable tr").each(function () {
        $(this).find("td, th").eq(index).addClass("selected");
      });
    }
  });
  // Desmarcar todas las celdas cuando se hace clic fuera de la tabla
  $(document).click(function (event) {
    if (!$(event.target).closest("#dynamicTable").length) {
      $("#dynamicTable .selected").removeClass("selected");
    }
  });
  // Función para eliminar tildes y espacios y convertir a mayúsculas
  function formatHeader(header) {
    const accentsMap = {
      á: "a",
      é: "e",
      í: "i",
      ó: "o",
      ú: "u",
      Á: "A",
      É: "E",
      Í: "I",
      Ó: "O",
      Ú: "U",
    };

    return header
      .split("")
      .map((char) => accentsMap[char] || char) // Reemplaza los caracteres acentuados
      .join("")
      .replace(/[\s.]+/g, "") // Elimina espacios y puntos
      .toUpperCase(); // Convierte a mayúsculas
  }
  // Función para formatear fechas al formato yyyy-mm-dd
  function formatDate(dateStr) {
    const [day, month, year] = dateStr.split(/[-\/]/);
    return `${year}-${month}-${day}`;
  }
  // Función para formatear valores monetarios
  function formatCurrency(value) {
    return value.replace(/[^\d]/g, "");
  }
  //subir datos
  $("#btnnueva").on("click", function () {    
    $("#btnnueva").prop("disabled", true);
    $("#overlay").show();

    let hasError = false;
    let isEmpty = false;

    // Campos requeridos
    const requiredFields = ["CÉDULA", "NOMBRE", "CONVENIO", "TELÉFONO"];

    // Variable para almacenar los campos vacíos
    let emptyFields = [];

    // Verificar si la primera fila tiene campos vacíos
    const firstRow = $("#dynamicTable tbody tr").first();

    // Iterar sobre cada celda en la primera fila
    firstRow.find("td").each(function () {
      const headerText = $("#dynamicTable thead th")
        .eq($(this).index())
        .text()
        .trim()
        .toUpperCase();

      // Verificar si el encabezado es uno de los campos requeridos
      if (requiredFields.includes(headerText)) {
        const cellValue = $(this).text().trim();

        // Verificar si la celda está vacía
        if (cellValue === "") {
          isEmpty = true;
          emptyFields.push(headerText); // Agregar encabezado del campo vacío
          $(this).addClass("error"); // Marcar la celda como error
        }

        if ($(this).hasClass("error")) {
          hasError = true;
        }
      }
    });

    isEmpty;

    // Mostrar mensaje de error
    if (isEmpty) {
      const fieldsWithError = emptyFields.join(", ");
      $("#overlay").hide();
      swal(
        "Error",
        `Los campos ${fieldsWithError} no deben estar vacíos.`,
        "error"
      );
    $("#btnnueva").prop("disabled", false);

    } else if (
      $("#dynamicTable tbody tr td.error").length > 0 ||
      hasError == true
    ) {
      $("#overlay").hide();
      swal("Error", "Complete todos los campos correctamente.", "error");
    $("#btnnueva").prop("disabled", false);
    } else {
      agregardatos(); // Llamar a la función para agregar datos si no hay errores
    }
  });
  function agregardatos() {
    const tableData = [];
    var headers = [];
    let skipIndex = -1;

    // Procesar los encabezados
    $("#dynamicTable thead th").each(function (index) {
      const headerText = $(this).text().trim();
      // Si el encabezado es "#", no lo proceses
      if (headerText !== "#") {
        headers.push(formatHeader(headerText));
      } else {
        skipIndex = index; // Almacenar el índice de la columna a omitir
      }
    });

    // Filtrar elementos vacíos o indefinidos
    headers = headers.filter((header) => header);

    // Procesar las filas de datos
    $("#dynamicTable tbody tr").each(function () {
      const rowData = {};

      $(this)
        .find("td")
        .each(function (index) {
          if (index !== skipIndex) {
            // Omitir la columna con el índice de `"#"`
            const header = headers[index < skipIndex ? index : index - 1]; // Ajustar el índice para headers

            let cellData = $(this).text().trim();

            // Validar y formatear columnas de tipo fecha
            if (/\d{2}[-\/]\d{2}[-\/]\d{4}/.test(cellData)) {
              cellData = formatDate(cellData);
            }

            // Validar y formatear columnas de tipo monetario
            if (/^\$\d{1,3}(,\d{3})*(\.\d{2})?$/.test(cellData)) {
              cellData = formatCurrency(cellData);
            }

            rowData[header] = cellData;
          }
        });

      // Solo agregar la fila si contiene datos válidos
      if (Object.keys(rowData).length > 0) {
        tableData.push(rowData);
      }
    });

    // const columns = headers.join(","); // Nombres de las columnas
    const columns = headers;
    const values = tableData; // Valores de las columnas

    // Enviar los datos a través de AJAX
    $.ajax({
      url: "../../controller/campana.php?op=columnas",
      type: "POST",
      data: {
        camp: camp,
        columns: JSON.stringify(columns),
        values: JSON.stringify(values),
      },
      // contentType: "application/json",
      success: function (response) {
      $("#overlay").hide();
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
              cambiarestado(camp);
              window.location.href = "../campanas/";

            } else {
              swal("Cancelado", "La campaña no ha sido activada.", "error");
              window.location.href = "../campanas/";
            }
          }
        );

        // Reiniciar la tabla a su estado inicial
        $("#dynamicTable").html(`
          <thead>
            <tr>
              <th class="row-header" style=" width: 1%;"></th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="CEDULA">Cédula</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="NOMBRE">Nombre</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="TELEFONO">Teléfono</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="CONVENIO">Convenio</th>
                                <th style=" width: 10%; background: #c5d2de;" data-value="CIUDAD">Ciudad</th>
                                <th style=" width: 10%;" data-value="DEPARTAMENTO">Departamento</th>
                                <th style=" width: 10%;" data-value="TELALTERNATIVO">Tel. Alternativo</th>
                                <th style=" width: 10%;" data-value="CORREO">Correo</th>
                                <th style=" width: 10%;" data-value="FECNACIMIENTO">F. Nacimiento</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="row-header">1</td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
          </tr>
          </tbody>
        `);
      },
      error: function (error) {
      $("#overlay").hide();
        swal("Error", "Error al enviar los datos: ".error, "error");
    $("#btnnueva").prop("disabled", false);

      },
    });
  }
  renumberRows();
});

function cambiarestado(cam_id) {
  $.ajax({
    type: "POST",
    url: "../../controller/campana.php?op=editarestado",
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
