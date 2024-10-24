<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/lib/clockpicker/bootstrap-clockpicker.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/project.min.css">
	<link rel="stylesheet" href="../../public/css/lib/summernote/summernote.css" />
	<link rel="stylesheet" href="../../public/css/separate/pages/editor.min.css">

	<?php require_once "../mainhead/head.php"; ?>
	<script>
		var usu_id = '<?php echo $usu_id; ?>';
		var usuPerfil = '<?php echo $usu_perfil; ?>';
	</script>
	<title>CRM :: Consola </title>
	<style>
		.oculto {
			display: none;
		}
		.visible {
			display: block;
		}
		#overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.7);
			z-index: 9999;
		}
		#overlay-content {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			text-align: center;
			color: white;
		}
	</style>
	</head>

	<body class="with-side-menu">
		<input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($_GET['i'] ?? ''); ?>">
		<input type="hidden" id="filtro" name="filtro" value="<?php echo htmlspecialchars($_GET['fil'] ?? ''); ?>">
		<input type="hidden" id="cam" name="cam" value="<?php echo htmlspecialchars($_GET['cam'] ?? ''); ?>">
		<?php require_once "../mainheader/header.php"; ?>


		<div class="page-content" style="padding-left: 5px;">
			<header class="page-content-header">
				<div class="container-fluid">
					<div class="tbl">
						<div class="tbl-row">
							<div class="tbl-cell" style="padding: 10px 0 10px;">
								<h3>Consola de Agente</h3>
							</div>

							<div class="tbl-cell tbl-cell-action" style="padding: 10px 0 10px;">
								<button id="tel" class="btn btn-inline btn-primary-outline" style="background-color: lightgray; color: white;" disabled><i class="fa fa-phone"></i></button>
								<!-- <button id="WhatsApp" class="btn  btn-inline btn-secondary-outline"> <i class="fa fa-whatsapp"></i></button> -->
								<button type="submit" id="terminar" class="btn btn-inline btn-danger" disabled="true">Terminar</button>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="container-fluid">
				<div class="row">
					<div class="col-xxl-4 col-xl-4">
						<section class="box-typical proj-page">

							<section class="proj-page-section">
								<ul class="proj-page-actions-list">
									<div class="chat-list-search chat-list-settings-header">
										<button type="button" class="btn btn-inline btn-success" id="llamar1" style="width: 60px; background-color: lightgray; border-color: lightgray" disabled><i class="fa fa-phone"></i> 1</button>
										<button type="button" class="btn btn-inline btn-success" id="llamar2" style="width: 60px; background-color: lightgray; border-color: lightgray" disabled><i class="fa fa-phone"></i> 2</button>
										<button type="button" class="btn btn-inline btn-warning" id="pausa" style="width: 60px;"><i class="fa fa-pause"></i> </button>
										<!-- <button type="button" class="btn btn-inline btn-danger" id="colgar" disabled="true"><i class="fa  fa-bell-slash"></i></button> -->
										<button type="button" class="btn btn-inline btn-primary" id="siguiente" style="width: 60px;" disabled="true"><i class="fa fa-random"></i> </button>
									</div>
								</ul>
							</section>

							<section class="proj-page-section proj-page-dates" id="sec-campaña">
								<header class="proj-page-subtitle padding-sm">
									<h3>Datos Campaña</h3>
								</header>
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-lbl">Nombre:</div>
										<div class="tbl-cell" id="nombrecam"></div>
									</div>
									<div class="tbl-row" id="textcont">
										<div class="tbl-cell tbl-cell-lbl">Contáctos:</div>
										<div class="tbl-cell" id="contactos"></div>
									</div>
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-lbl">Vencimiento:</div>
										<div class="tbl-cell" id="vencimiento"></div>
									</div>
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-lbl">Horario:</div>
										<div class="tbl-cell" id="horario"></div>
									</div>
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-lbl">Intentos:</div>
										<div class="tbl-cell" id="intentos"></div>
									</div>
								</div>
							</section><!--.proj-page-section-->


							<section class="proj-page-section proj-page-dates">
								<header class="proj-page-subtitle padding-sm">
									<h3>Datos Cliente</h3>
								</header>
								<table class="tbl" id="datosContainer">
								</table>
							</section><!--.proj-page-section-->

							<section class="proj-page-section" id="sec-comen">
								<header class="proj-page-subtitle padding-sm">
									<h3>Comentarios</h3>
								</header>
								<a id="comentarios"></a>
							</section><!--.proj-page-section-->

						</section><!--.proj-page-->
					</div>

					<div class="col-xxl-8 col-xl-8">

						<section class="proj-page-add-txt">
							<select id="seleccion" disabled="true" onchange="mostrarSeccion()" class="select2 select2-no-search-arrow select2-hidden-accessible" require>
								<option value="seccion0">Seleccionar</option>
								<option value="seccion3">Interesado</option>
								<option value="seccion1">No interesado</option>
								<option value="seccion2">Volver a llamar</option>
								<option value="seccion1">Ilocalizado</option>
								<option value="seccion1">Buzón de Voz</option>
								<option value="seccion1">Numero Equivocado</option>
								<option value="seccion1">Fuera de Servicio</option>
								<option value="seccion1">Fallecido</option>
							</select>

							<button type="button" class="btn btn-inline btn-primary" id="Guardar" style="background-color: gray;"> Guardar </button>

						</section><!--.proj-page-add-txt-->

						<div id="seccion1" class="oculto">
							<div class="box-typical box-typical-padding">
								<div class="row">
									<div class="col-xs-12">
										<fieldset class="form-group">
											<textarea rows="6" class="form-control" placeholder="Observaciones" id="cli_des" name="cli_des"></textarea>
										</fieldset>
									</div>
								</div>
							</div>
						</div>

						<div id="seccion2" class="oculto">
							<div class="box-typical box-typical-padding">
								<div class="row">

									<div class="col-xs-6">
										<div class="form-group">
											<label class="form-label" for="cli_agenda">Fecha: </label>
											<div class="input-group date">
												<input id="cli_agenda" name="cli_agenda" type="text" value="" class="form-control" wfd-id="id8" required>
												<span class="input-group-addon" style="font-size: 14px;">
													<i class="font-icon font-icon-calend"></i>
												</span>
											</div>
										</div>
									</div>

									<div class="col-xs-6">
										<div class="form-group">
											<label class="form-label" for="cli_hora">Hora: </label>
											<div class="input-group clockpicker" data-autoclose="true">
												<input name="cli_hora" type="text" class="form-control" id="cli_hora" value="00:00" required>
												<span class="input-group-addon" style="font-size: 14px;">
													<span class="glyphicon glyphicon-time font-icon"></span>
												</span>
											</div>
										</div>
									</div>

									<div class="col-xs-12">
										<fieldset class="form-group">
											<textarea rows="6" class="form-control" placeholder="Observaciones" id="cli_des2" name="cli_des"></textarea>
										</fieldset>
									</div>
								</div>
							</div>
						</div>

						<div id="seccion3" class="oculto">
							<div class="box-typical box-typical-padding">
								<div class="row">
									<div class="box-typical box-typical-padding">
										<h5>Crear Cliente</h5>

										<!-- Agregar el formulario de creación de cliente aquí -->
										<?php include_once "../crearcliente/formulario.php"; ?>

										<label class="form-label semibold" for="com_client">Descripción</label>
										<div class="summernote-theme-1">
											<textarea id="com_client" name="com_client" class="summernote" name="name"></textarea>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div id="seccion0" class="oculto">
						</div>

					</div>
				</div>
			</div><!--.container-fluid-->
		</div><!--.page-content-->
		<?php require_once "modalpausa.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="consola.js"></script>

		<script>
			$(function() {
				function cb(start, end) {
					$('#reportrange span').html(start.format('D [de] MMMM [de] YYYY') + ' - ' + end.format('D [de] MMMM [de] YYYY'));
				}
				cb(moment().subtract(29, 'days'), moment());

				$('#cli_edad').daterangepicker({
					locale: {
						format: 'DD/MM/YYYY',
						"applyLabel": "Aplicar",
						"cancelLabel": "Cancelar",
						"fromLabel": "Desde",
						"toLabel": "Hasta",
						"customRangeLabel": "Rango personalizado",
						"weekLabel": "S",
						"daysOfWeek": [
							"Do",
							"Lu",
							"Ma",
							"Mi",
							"Ju",
							"Vi",
							"Sá"
						],
						"monthNames": [
							"Ene",
							"Feb",
							"Mar",
							"Abr",
							"May",
							"Jun",
							"Jul",
							"Ago",
							"Sep",
							"Oct",
							"Nov",
							"Dic"
						],
						"firstDay": 1
					},
					singleDatePicker: true,
					showDropdowns: true
				});
			});
		</script>
		<script>
			$(function() {
				function cb(start, end) {
					$('#reportrange span').html(start.format('D [de] MMMM [de] YYYY') + ' - ' + end.format('D [de] MMMM [de] YYYY'));
				}
				cb(moment().subtract(29, 'days'), moment());

				$('#cli_agenda').daterangepicker({
					locale: {
						format: 'DD/MM/YYYY',
						"applyLabel": "Aplicar",
						"cancelLabel": "Cancelar",
						"fromLabel": "Desde",
						"toLabel": "Hasta",
						"customRangeLabel": "Rango personalizado",
						"weekLabel": "S",
						"daysOfWeek": [
							"Do",
							"Lu",
							"Ma",
							"Mi",
							"Ju",
							"Vi",
							"Sá"
						],
						"monthNames": [
							"Ene",
							"Feb",
							"Mar",
							"Abr",
							"May",
							"Jun",
							"Jul",
							"Ago",
							"Sep",
							"Oct",
							"Nov",
							"Dic"
						],
						"firstDay": 1
					},
					singleDatePicker: true,
					showDropdowns: true
				});
			});
		</script>

		<script>
			function mostrarSeccion() {

				// Obtener el valor seleccionado en el combobox
				var seleccion = document.getElementById("seleccion").value;
				// console.log(seleccion)

				// Ocultar todas las secciones
				seccion1.className = "oculto"
				seccion2.className = "oculto"
				seccion3.className = "oculto"
				seccion0.className = "oculto"

				// Mostrar la sección seleccionada
				document.getElementById(seleccion).className = "visible";
			}
		</script>
		<script>
			// Función para cambiar la clase del div al hacer clic en el botón "tel"
			document.getElementById("tel").addEventListener("click", function() {
				var miDiv = document.getElementById("miDiv");

				// Cambia la clase del div
				miDiv.classList.toggle("visible");
			});
		</script>
	</body>

	<div id="overlay" style="display: none;">
		<div id="overlay-content">
			<p>La ventana está en pausa.</p>
			<button type="submit" class="form-control btn btn-inline btn-primary" onclick="quitarPausa()">Quitar Pausa </button>
		</div>
	</div>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>