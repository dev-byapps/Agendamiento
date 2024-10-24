<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) { ?>

	<!DOCTYPE html>
	<html>

	<input type="hidden" id="ent_id" name="ent_id" value="<?php echo htmlspecialchars($_GET['ent_id'] ?? ''); ?>">
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<?php require_once "../mainhead/head.php"; ?>

	<title>CRM :: Registros </title>

	</head>

	<body class="with-side-menu">

		<?php require_once "../mainheader/header.php"; ?>

		<div class="mobile-menu-left-overlay"></div>

		<?php require_once "../mainnav/nav.php"; ?>

		<div class="page-content">


			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
						<li class="active">Registros</li>
					</ol>

				</div>
			</header>



			<div class="container-fluid">

				<section class="card card-default">
					<header class="card-header">
						Filtros
					</header>

					<div class="card-block">

						<form method="post" id="filtros_form">

							<input type="hidden" id="usu_perfil" name="usu_perfil" value="<?php echo $_SESSION["usu_perfil"] ?>">

							<div class="row" id="viewuser">

								<div class="col-lg-12">

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

									<div class="col-lg-3">
										<fieldset class="form-group">
											<label class="form-label semibold">Tipo</label>
											<select class="select2" id="fil_grupo" name="fil_grupo" data-placeholder="Seleccionar">
												<option>Comercial</option>
												<option>ContactCenter</option>
												<option>Intranet</option>
												<option>Informes</option>
												<option>Configuraciones</option>
												<option>Seguridad</option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-3">
										<fieldset class="form-group">
											<label class="form-label semibold">Usuario</label>
											<select class="select2" id="fil_entidad" name="fil_entidad" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-2 ">
										<button class="btn btn-primary btn-block" id="btntodo" style="margin-top: 27px;">Limpiar</button>
									</div>

								</div>
							</div>
						</form>
					</div>
				</section>


				<div class="box-typical box-typical-padding" id="table">
					<table id="registro_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 25%;">Detalle</th>
								<th style="width: 15%;">Tipo</th>
								<th style="width: 15%;">Fecha</th>
								<th style="width: 15%;">Usuario</th>
								<th style="width: 15%;">Dispositivo</th>
								<th style="width: 15%;">IP</th>

							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div><!--.container-fluid-->
		</div><!--.page-content-->
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="registros.js"></script>

		<script>
			$(function() {

				$('#daterange').daterangepicker({

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

				});


				/* ==========================================================================
				 Datepicker
				 ========================================================================== */

				var currentDate = new Date();
				// Configuración regional en español
				var localeConfig = {
					format: 'DD/MM/YYYY',
					daysOfWeek: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
					monthNames: [
						"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
						"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
					]
				};

				$('#tar_fcierre').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig

				});
			});
		</script><!--.Funcion DateTIME-->
	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>