<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">

	<?php require_once "../mainhead/head.php"; ?>

	<style>
		table.dataTable {
			margin-top: 0px !important;
		}
	</style>

	<title>CRM:: Informes Contact Center </title>

	<body class="with-side-menu">
		<?php require_once "../mainheader/header.php"; ?>
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once "../mainnav/nav.php"; ?>
		<div class="page-content">
			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
						<li class="active">Informes Contact Center</li>
					</ol>
				</div>
			</header>

			<div class="container-fluid">

				<section class="card card-default">
					<header class="card-header">
						Informe Llamadas
					</header>
					<div class="card-block">
						<form method="post" id="informescc_form">
							<div class="row" id="viewuser">
								<div class="col-lg-12">

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Campaña</label>
											<select class="select2" id="fil_camp" name="fil_camp" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Asesor</label>
											<select class="select2" id="fil_asesor" name="fil_asesor" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Fechas</label>
											<div class="input-group date">
												<input id="daterange" name="daterange" type="text" class="form-control">
												<span class="input-group-addon">
													<i class="font-icon font-icon-calend"></i>
												</span>
											</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<button class="btn btn-primary btn-block" id="generar_cc" style="margin-top: 27px;" disabled>Generar</button>
							</div>

						</form>
					</div>
				</section>

				<section class="card card-default">
					<header class="card-header">
						Informe Agendas
					</header>
					<div class="card-block">
						<form method="post" id="informesAgenda_form">
							<div class="row" id="viewuser">
								<div class="col-lg-12">

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Grupo</label>
											<select class="select2" id="fil_grupo" name="fil_grupo" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Asesor</label>
											<select class="select2" id="fil_asesor1" name="fil_asesor1" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Fechas</label>
											<div class="input-group date">
												<input id="daterange1" name="daterange1" type="text" class="form-control">
												<span class="input-group-addon">
													<i class="font-icon font-icon-calend"></i>
												</span>
											</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<button class="btn btn-primary btn-block" id="generar_Agenda" style="margin-top: 27px;" disabled>Generar</button>
							</div>

						</form>
					</div>
				</section>

				<section class="card card-default">
					<header class="card-header">
						Informe Registro Agentes
					</header>
					<div class="card-block">
						<form method="post" id="informesRagent_form">
							<div class="row" id="viewuser">
								<div class="col-lg-12">

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Grupo</label>
											<select class="select2" id="fil_grupo1" name="fil_grupo1" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Asesor</label>
											<select class="select2" id="fil_asesor2" name="fil_asesor2" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Fechas</label>
											<div class="input-group date">
												<input id="daterange2" name="daterange2" type="text" class="form-control">
												<span class="input-group-addon">
													<i class="font-icon font-icon-calend"></i>
												</span>
											</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<button class="btn btn-primary btn-block" id="generar_ragente" style="margin-top: 27px;" disabled>Generar</button>
							</div>

						</form>
					</div>
				</section>

				<section class="card card-default">
					<header class="card-header">
						Descargar Base Completa
					</header>
					<div class="card-block">
						<form method="post" id="informesbscomp_form">
							<div class="row" id="viewuser">
								<div class="col-lg-12">

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Campaña</label>
											<select class="select2" id="fil_camp2" name="fil_camp2" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

								</div>
							</div>

							<div class="col-lg-4">
								<button class="btn btn-primary btn-block" id="generar_bscom" style="margin-top: 27px;" disabled>Generar</button>
							</div>

						</form>
					</div>
				</section>

			</div><!--.container-fluid-->
		</div><!--.page-content-->

		<?php require_once "../mainjs/js.php"; ?>

		<script>
			$(function() {
				// Configuración común para ambos datepickers
				var commonConfig = {
					locale: {
						format: 'DD/MM/YYYY',
						applyLabel: "Aplicar",
						cancelLabel: "Cancelar",
						"customRangeLabel": "Personalizado",
						daysOfWeek: [
							"D",
							"L",
							"M",
							"M",
							"J",
							"V",
							"S"
						],
						monthNames: [
							"Enero",
							"Febrero",
							"Marzo",
							"Abril",
							"Mayo",
							"Junio",
							"Julio",
							"Agosto",
							"Septiembre",
							"Octubre",
							"Noviembre",
							"Diciembre"
						],
					},
					startDate: moment().startOf('month'),
					endDate: moment(),
					autoApply: true,
					ranges: {
						'Hoy': [moment(), moment()],
						'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
						'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
						'Este Mes': [moment().startOf('month'), moment().endOf('month')],
						'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					},
					"alwaysShowCalendars": true,
				};

				// Inicializar daterangepicker para #daterange
				$('#daterange').daterangepicker(commonConfig);

				// Inicializar daterangepicker para #daterange1
				$('#daterange1').daterangepicker(commonConfig);

				// Inicializar daterangepicker para #daterange2
				$('#daterange2').daterangepicker(commonConfig);

			});
		</script>

		<script type="text/javascript" src="infocc.js"></script>

	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>