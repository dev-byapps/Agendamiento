<?php
require_once "../../config/conexion.php";
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
$usu_grupocom = isset($_SESSION["usu_grupocom"]) ? $_SESSION["usu_grupocom"] : '';
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$source = isset($_GET['s']) ? $_GET['s'] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<script>
		var usuPerfil = '<?php echo $usu_perfil; ?>';
		var usu_id = '<?php echo $usu_id; ?>';
		var form = '<?php echo $source; ?>';
		var grupoc = '<?php echo $usu_grupocom; ?>';
	</script>

	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Crear Cliente </title>
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
						<li class="active" id="titulo">Crear Cliente</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="box-typical box-typical-padding">
					<h5 class="m-t-lg with-border">Información del Cliente</h5>
					<?php
					if ($source == 'cc') {
						include_once "formulario.php";
					} elseif ($source == 'cp') {
						include_once "consulta.php";
					} else {
					}
					?>
				</div>
			</div>
		</div>

		<?php require_once "../mainjs/js.php"; ?>
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
		<script type="text/javascript" src="crearcliente.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>