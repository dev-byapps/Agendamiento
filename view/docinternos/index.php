<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/lib/lobipanel/lobipanel.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/lobipanel.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/files.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/widgets.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Documentos Internos </title>
	</head>

	<body class="with-side-menu">
		<script>
			var usu_id = "<?php echo $usu_id ?>";
			var usu_perfil = "<?php echo $usu_perfil ?>";
		</script>
		<?php require_once "../mainheader/header.php"; ?>
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once "../mainnav/nav.php"; ?>
		<div class="page-content">
			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
						<li class="active">Documentos Internos</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<?php
				if (
					$_SESSION["usu_perfil"] != "Calidad" &&
					$_SESSION["usu_perfil"] != "Operativo" &&
					$_SESSION["usu_perfil"] != "Coordinador" &&
					$_SESSION["usu_perfil"] != "Asesor" &&
					$_SESSION["usu_perfil"] != "Agente" &&
					$_SESSION["usu_perfil"] != "Asesor/Agente"

				) {
				?>
					<div class="col-xl-12" style="padding: 5px;">
						<button type="button" id="btnnuevo" class="btn btn-inline btn-primary"><i class="fa fa-plus"></i>&nbsp;Documento</button>
					</div>
				<?php
				} ?>
				<div class="col-xl-3" style="padding: 5px;">
					<div class="box-typical lobipanel">
						<header class="box-typical-header panel-heading">
							<h3 class="panel-title" style="max-width:none;">Categorias</h3>
							<?php
							if (
								$_SESSION["usu_perfil"] != "Calidad" &&
								$_SESSION["usu_perfil"] != "Operativo" &&
								$_SESSION["usu_perfil"] != "Coordinador" &&
								$_SESSION["usu_perfil"] != "Asesor" &&
								$_SESSION["usu_perfil"] != "Agente" &&
								$_SESSION["usu_perfil"] != "Asesor/Agente"
							) {
							?>
								<div class="dropdown dropdown-menu-right">
									<a id="btn_newcat" title="Crear">
										<i class="panel-control-icon glyphicon glyphicon-plus"></i>
									</a>
								</div>
							<?php
							} ?>
						</header>
						<div class="files-manager">
							<ul class="files-manager-side-list"></ul>
						</div>
					</div>
				</div>
				<div class="col-xl-9" style="padding: 5px;">
					<div class="box-typical lobipanel col-xl-12 p-a-0">
						<header class="box-typical-header panel-heading">
							<h3 class="panel-title" style="max-width: calc(100% - 50px);" id="nomcat">
							</h3>
							<div class="dropdown dropdown-menu-right">
								<a id="edit-icon" data-func="editaenombre" data-tooltip="Editar" data-toggle="tooltip" data-title="Editar" data-placement="bottom" data-original-title="" title=""><i class="panel-control-icon glyphicon-pencil glyphicon" style="margin-right: 10px;"></i></a>
								<a id="eliminarcat" data-func="eliminar" data-tooltip="Eliminar" data-toggle="tooltip" data-title="Eliminar" data-placement="bottom" data-original-title="" title=""><i class="panel-control-icon glyphicon glyphicon-trash"></i></a>
							</div>
						</header>

						<div style="border-bottom: 2px solid #f0f0f0; margin-bottom: 5px;"></div>

						<table id="entidad_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
							<thead>
								<tr>
									<th style="width: 40%;">Nombre</th>
									<th style="width: 20%;">Creado por</th>
									<th style="width: 20%;">Fecha</th>
									<th class="text-center" style="width: 20%;">Acciones</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php require_once "modaldocumento.php"; ?>
		<?php require_once "modalcategoria.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="docinternos.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>