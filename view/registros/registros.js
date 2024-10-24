var tabla;

/* TODO: Limpiar Inputs */
$(document).on("click", "#btnnuevo", function () {
  $("#est_id").val("");
  $("#mdltitulo").html("Nueva Ciudad");
  $("#estadoent_form")[0].reset();

  /* TODO:Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();
