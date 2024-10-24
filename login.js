function init() {}

$(document).on("click", "#resetpass", function () {
  $("#mdltitulo").html("Restablecer la contraseña");
  $("#modalresetpass").modal("show");
});

$(document).on("click", "#autpc", function () {
  $("#mdltitulo").html("Restablecer la contraseña");
  $("#modalautpc").modal("show");
});


init();
