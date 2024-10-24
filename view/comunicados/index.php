<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<script>
		var usu_id = '<?php echo $usu_id; ?>';
		var usuPerfil = '<?php echo $usu_perfil; ?>';
	</script>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/lib/summernote/summernote.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/editor.min.css">
	<link rel="stylesheet" href="../../public/css/separate/elements/cards.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Comunicados </title>
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
						<li class="active">Comunicados</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="box-typical box-typical-padding" id="table">
					<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador" && $usu_perfil != "Operativo" && $usu_perfil != "Agente" && $usu_perfil != "Asesor/Agente") { ?>

						<button type="button" id="btnnuevo" class="btn btn-inline btn-primary"><i class="fa fa-plus-circle"></i> Comunicado</button>
						<!-- <button type="button" id="papelera" class="btn btn-inline btn-danger"><i class="fa fa-trash"></i></button> -->
					<?php } ?>
					<table id="comunicados_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width:40%;">Asunto</th>
								<th style="width:10%;">Creado por</th>
								<th style="width:10%;">Clasificación</th>
								<th style="width:10%;">Creado</th>
								<th style="width:10%;">Vencimiento</th>
								<th style="width:10%;">Estado</th>
								<th class="text-center" style="width: 10%;">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		<?php require_once "modalcomunicado.php"; ?>
		<?php require_once "modalvisual.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="comunicados.js"></script>
		<script>
			$(function() {
				// Obtener la fecha actual
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
				$('#com_fcierre').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
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