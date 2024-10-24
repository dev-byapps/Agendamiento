<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Usuarios </title>
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
						<li class="active">Usuarios</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="box-typical box-typical-padding" id="table">
					<button type="button" id="btnnuevo" class="btn btn-inline btn-primary"><i class="fa fa-plus-circle"></i> Usuario</button>

					<button type="button" id="papelera" class="btn btn-inline btn-danger"><i class="fa fa-trash"></i>&nbsp;Papelera</button>

					<table id="usuario_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 20%;">Usuario</th>
								<th style="width: 30%;">Nombre</th>
								<th style="width: 15%;">Perfil</th>
								<th style="width: 15%;">Estado</th>
								<th class="text-center" style="width: 20%;">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		<?php require_once "modalsip.php"; ?>
		<?php require_once "modalinformacion.php"; ?>
		<?php require_once "modalmantenimiento.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="usuarios.js"></script>

	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>