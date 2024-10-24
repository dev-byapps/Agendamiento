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

	<title>CRM:: Informes </title>

	<body class="with-side-menu">
		<?php require_once "../mainheader/header.php"; ?>
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once "../mainnav/nav.php"; ?>
		<div class="page-content">
			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
						<li class="active">Informes Comerciales</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<?php
				// <section class="card card-default">
				//     <header class="card-header">
				//         Informe Consultas
				//     </header>

				//     <div class="card-block">
				//         <form method="post" id="consultas_form">
				//             <div class="row" id="viewuser">
				//                 <div class="col-lg-12">
				//                     <div class="col-lg-4">
				//                         <fieldset class="form-group">
				//                             <label class="form-label semibold">Fechas</label>
				//                             <div class="input-group date">
				//                                 <input id="daterange" name="daterange" type="text" class="form-control">
				//                                 <span class="input-group-addon">
				//                                     <i class="font-icon font-icon-calend"></i>
				//                                 </span>
				//                             </div>
				//                         </fieldset>
				//                     </div>

				//                     <div class="col-lg-4">
				//                         <fieldset class="form-group">
				//                             <label class="form-label semibold">Entidad</label>
				//                             <select class="select2" id="fil_entidad" name="fil_entidad" data-placeholder="Seleccionar">
				//                                 <option label="Seleccionar"></option>
				//                             </select>
				//                         </fieldset>
				//                     </div>

				//                     <div class="col-lg-4">
				//                         <fieldset class="form-group">
				//                             <label class="form-label semibold">Grupo</label>
				//                             <select class="select2" id="fil_grupo" name="fil_grupo" data-placeholder="Seleccionar">
				//                             </select>

				//                         </fieldset>
				//                     </div>

				//                     <div class="col-lg-4">
				//                         <fieldset class="form-group">
				//                             <label class="form-label semibold">Asesor</label>
				//                             <select class="select2" id="fil_asesor" name="fil_asesor" data-placeholder="Seleccionar">
				//                                 <option label="Seleccionar"></option>
				//                             </select>
				//                         </fieldset>
				//                     </div>

				//                     <div class="col-lg-2 ">
				//                         <button class="btn btn-primary btn-block" id="generar_consulta" style="margin-top: 27px;" disabled>Generar</button>
				//                     </div>

				//                 </div>
				//             </div>
				//         </form>
				//     </div>
				// </section>
				?>

				<section class="card card-default">
					<header class="card-header">
						Informe Operaciones
					</header>
					<div class="card-block">
						<form method="post" id="operaciones_form">
							<div class="row" id="viewuser">
								<div class="col-lg-12">
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

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Entidad</label>
											<select class="select2" id="fil_entidad_ope" name="fil_entidad_ope" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Grupo</label>
											<select class="select2" id="fil_grupo_ope" name="fil_grupo_ope" data-placeholder="Seleccionar">
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Asesor</label>
											<select class="select2" id="fil_asesor_ope" name="fil_asesor_ope" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-2 ">
										<button class="btn btn-primary btn-block" id="generar_ope" style="margin-top: 27px;" disabled>Generar</button>
									</div>

								</div>
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

				// Inicializar daterangepicker para #daterange2
				$('#daterange2').daterangepicker(commonConfig);

				/* ==========================================================================
		 		Datepicker
		 		========================================================================== */

				$('.datetimepicker-1').datetimepicker({
					widgetPositioning: {
						horizontal: 'right'
					},
					debug: false
				});

				$('.datetimepicker-2').datetimepicker({
					widgetPositioning: {
						horizontal: 'right'
					},
					format: 'LT',
					debug: false
				});
			});
		</script>

		<script type="text/javascript" src="informes.js"></script>

	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>