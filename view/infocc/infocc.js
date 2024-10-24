function init() {
  listar_campanas();
}

//Listar datos
function listar_campanas() {
  $.post(
    "../../controller/campana.php?op=todasCampanas",
    function (data, status) {
      $("#fil_camp").html(data);
      $("#fil_camp2").html(data);
      listar_asesor();
      if($("#fil_camp").val() == 0){
        $("#generar_bscom").prop("disabled", true);
      }else{
        $("#generar_bscom").prop("disabled", false);
      }      
    }
  );
}
function listar_asesor() {
  $.post("../../controller/usuario.php?op=admin", function (data, status) {
    var campotodo = '<option value="0">TODO</option>' + data;
    $("#fil_asesor").html(campotodo);
    $("#fil_asesor1").html(campotodo);
    $("#fil_asesor2").html(campotodo);
    if($("#fil_camp").val() == 0){
      $("#generar_cc").prop("disabled", true);
    }else{
      $("#generar_cc").prop("disabled", false);
    } 
  });

  listar_grupos();
}
function listar_grupos() {
  $.post("../../controller/grupocc.php?op=get", function (data, status) {
    var campotodo = '<option value="0">TODO</option>' + data;
    $("#fil_grupo").html(campotodo);
    $("#fil_grupo1").html(campotodo);
    $("#generar_Agenda").prop("disabled", false);
    $("#generar_ragente").prop("disabled", false);
  });
}
$("#fil_grupo").on("change", function () {
  $("#generar_Agenda").prop("disabled", true);
  $("#fil_asesor1").prop("disabled", true);

  var grupo = $("#fil_grupo").val();

  if (grupo == 0) {
    $.post("../../controller/usuario.php?op=admin", function (data, status) {
      var campotodo = '<option value="0">TODO</option>' + data;
      $("#fil_asesor1").html(campotodo);
      $("#fil_asesor1").prop("disabled", false);
      $("#generar_Agenda").prop("disabled", false);
    });
  } else {
    $.post(
      "../../controller/grupocc.php?op=mostrarintegrantescc",
      { grupo: grupo },
      function (data, status) {
        var campotodo = '<option value="0">TODO</option>' + data;
        $("#fil_asesor1").html(campotodo);
        $("#fil_asesor1").prop("disabled", false);
        $("#generar_Agenda").prop("disabled", false);
      }
    );
  }
});
$("#fil_grupo1").on("change", function () {
  $("#generar_ragente").prop("disabled", true);
  $("#fil_asesor2").prop("disabled", true);

  var grupo = $("#fil_grupo1").val();

  if (grupo == 0) {
    $.post("../../controller/usuario.php?op=admin", function (data, status) {
      var campotodo = '<option value="0">TODO</option>' + data;
      $("#fil_asesor2").html(campotodo);
      $("#fil_asesor2").prop("disabled", false);
      $("#generar_ragente").prop("disabled", false);
    });
  } else {
    $.post(
      "../../controller/grupocc.php?op=mostrarintegrantescc",
      { grupo: grupo },
      function (data, status) {
        var campotodo = '<option value="0">TODO</option>' + data;
        $("#fil_asesor2").html(campotodo);
        $("#fil_asesor2").prop("disabled", false);
        $("#generar_ragente").prop("disabled", false);
      }
    );
  }
});

// FILTROS
$(document).on("click", "#generar_cc", function (e) {
  e.preventDefault();
  $("#generar_cc").prop("disabled", true);

  var formData = new FormData($("#informescc_form")[0]);

  $.ajax({
    url: "../../controller/informecc.php?op=inf_llamadas",
    type: "POST",
    data: formData,
    processData: false, // Necesario para que jQuery no procese los datos
    contentType: false,
    success: function (response) {
      var data = JSON.parse(response);
      $("#generar_cc").prop("disabled", false);

      if (data.file) {
        window.location.href = "../" + data.file;
      } else {
        swal({
          title: "Error",
          text: "No se pudo generar el archivo o no se encontraron datos",
          type: "error",
          confirmButtonClass: "btn-danger",
        });
        $("#generar_cc").prop("disabled", false);
      }
    },
  });
});
$(document).on("click", "#generar_Agenda", function (e) {
  e.preventDefault();
  $("#generar_Agenda").prop("disabled", true);

  var formData = new FormData($("#informesAgenda_form")[0]);

  $.ajax({
    url: "../../controller/informecc.php?op=info_agenda",
    type: "POST",
    data: formData,
    processData: false, // Necesario para que jQuery no procese los datos
    contentType: false,
    success: function (response) {
      console.log(response);
      var data = JSON.parse(response);
      $("#generar_Agenda").prop("disabled", false);

      if (data.file) {
        window.location.href = "../" + data.file;
      } else {
        swal({
          title: "Error",
          text: "No se pudo generar el archivo o no se encontraron datos",
          type: "error",
          confirmButtonClass: "btn-danger",
        });
        $("#generar_Agenda").prop("disabled", false);
      }
    },
  });
});
//pendiente
$(document).on("click", "#generar_ragente", function (e) {
  e.preventDefault();
  $("#generar_ragente").prop("disabled", true);

  var formData = new FormData($("#informesRagent_form")[0]);

  $.ajax({
    url: "../../controller/informecc.php?op=inf_ragente",
    type: "POST",
    data: formData,
    processData: false, // Necesario para que jQuery no procese los datos
    contentType: false,
    success: function (response) {
      var data = JSON.parse(response);
      $("#generar_ragente").prop("disabled", false);

      if (data.file) {
        window.location.href = "../" + data.file;
      } else {
        swal({
          title: "Error",
          text: "No se pudo generar el archivo o no se encontraron datos",
          type: "error",
          confirmButtonClass: "btn-danger",
        });
        $("#generar_ragente").prop("disabled", false);
      }
    },
  });
});
$(document).on("click", "#generar_bscom", function (e) {
  e.preventDefault();
  $("#generar_bscom").prop("disabled", true);

  var formData = new FormData($("#informesbscomp_form")[0]);
  var selectedText = $("#fil_camp2 option:selected").text();
  formData.append("nomcamp", selectedText);

  $.ajax({
    url: "../../controller/informecc.php?op=inf_base",
    type: "POST",
    data: formData,
    processData: false, // Necesario para que jQuery no procese los datos
    contentType: false,
    success: function (response) {
      var data = JSON.parse(response);
      $("#generar_bscom").prop("disabled", false);

      if (data.file) {
        window.location.href = "../" + data.file;
      } else {
        swal({
          title: "Error",
          text: "No se pudo generar el archivo o no se encontraron datos",
          type: "error",
          confirmButtonClass: "btn-danger",
        });
        $("#generar_bscom").prop("disabled", false);
      }
    },
  });
});

init();
