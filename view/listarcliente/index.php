<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Listado Clientes </title>
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
						<li><a href="../dashcomercial/">Dashboard</a></li>
						<li class="active" id="titulo"></li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="box-typical box-typical-padding" id="table">
					<table id="ticket_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 10%;">Identificación</th>
								<th style="width: 20%;">Nombre</th>
								<th class="d-none d-sm-table-cell" style="width: 15%;">Convenio</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Entidad</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Asesor</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Ciudad</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Estado</th>
								<th style="width: 1%;"></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>

		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="listarcliente.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>