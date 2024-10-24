<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<input type="hidden" id="ent_id" name="ent_id" value="<?php echo htmlspecialchars($_GET['ent_id'] ?? ''); ?>">
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Estados Entidades </title>
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
						<li><a style="color:#5B80A3" href="../entidades/">Entidades</a></li>
						<li class="active">Estados <span id="lbltitle"><?php echo htmlspecialchars($_GET['nom'] ?? ''); ?></span>
						</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="box-typical box-typical-padding" id="table">
					<button type="button" id="btnnuevo" class="btn btn-inline btn-primary"><i class="fa fa-plus-circle"></i> Estado</button>

					<table id="estadoent_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 50%;">Estado Entidad</th>
								<th style="width: 30%;">Estado CRM</th>
								<th class="text-center" style="width: 20%;">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		<?php require_once "modalmantenimiento.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="entestados.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>