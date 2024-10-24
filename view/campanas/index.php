<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/lib/clockpicker/bootstrap-clockpicker.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Campañas</title>
	<style>
		#barraP {
			display: none;
		}
	</style>
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
						<li class="active">Campañas</li>
					</ol>
				</div>
			</header>

			<div class="container-fluid">

				<div id="barraP">
					<progress class="progress" value="1" max="100" id="progreso">
						<div class="progress">
							<span class="progress-bar" style="width: 100%;">100%</span>
						</div>
					</progress>
					<div class="uploading-list-item-progress" id="completado">Cargando</div>
					<div class="uploading-list-item-speed" id="contactos">Progreso: <span id="progreso_actual">0</span> de <span id="total_clientes">0</span></div>
				</div>

				<div class="box-typical box-typical-padding" id="table">

					<button type="button" id="btnnuevo" class="btn btn-inline btn-primary"><i class="fa fa-plus"></i>&nbsp;Campaña</button>

					<button type="button" id="papelera" class="btn btn-inline btn-danger "><i class="fa fa-trash"></i>&nbsp;Cerrados</button>

					<table id="campana_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 30%;">Nombre</th>
								<th class="d-none d-sm-table-cell" style="width: 15%;">Vencimiento</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Horario</th>
								<th class="d-none d-sm-table-cell" style="width: 20%;">Grupo</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Estado</th>
								<th class="text-center" style="width: 15%;">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>

			</div>
		</div>
		<?php require_once "modalmantenimiento.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="campanas.js"></script>

		<script>
			$(function() {
				// Obtener la fecha actual
				var currentDate = new Date();
				// Configuración regional en español
				var localeConfig = {
					format: 'DD/MM/YYYY',
					daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
					monthNames: [
						"Ene", "Feb", "Mar", "Abr", "May", "Jun",
						"Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
					]
				};

				$('#fec_ini').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
				});

				$('#fec_fin').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
				});

			});
		</script>
		<script>
			$(document).ready(function() {
				$("input[name='cam_int']").TouchSpin({
					verticalbuttons: true,
					verticalupclass: 'glyphicon glyphicon-plus',
					verticaldownclass: 'glyphicon glyphicon-minus'
				});
			});
		</script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>