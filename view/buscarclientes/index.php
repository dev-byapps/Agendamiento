<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
$usu_grupocom = isset($_SESSION["usu_grupocom"]) ? $_SESSION["usu_grupocom"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<script>
		var usuPerfil = '<?php echo $usu_perfil; ?>';
		var usu_grupocom = '<?php echo $usu_grupocom; ?>';
		var usu_id = '<?php echo $usu_id; ?>';
	</script>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Buscar Clientes </title>
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
						<li class="active">Buscar Clientes</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="box-typical box-typical-padding">
					<form method="post" id="filtros_busqueda">
						<div class="row" id="viewuser">

							<div class="col-lg-3">
								<fieldset class="form-group">
									<label class="form-label semibold" for="cat_id">Buscar por</label>
									<select class="select2  select2-no-search-default" id="filtroB" name="cat_id" data-placeholder="Seleccionar">
										<option value="Cedula">IDENTIFICACIÓN</option>
										<option value="Nombre">NOMBRE</option>
										<option value="Telefono">TELÉFONO</option>
									</select>
								</fieldset>
							</div>

							<div class="col-lg-5">
								<fieldset class="form-group">
									<label class="form-label semibold" for="tick_titulo">Busqueda</label>
									<input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="" style="font-size: 16px;" required>
								</fieldset>
							</div>

							<div class="col-lg-2">
								<fieldset class="form-group">
									<button type="submit" class="btn btn-primary btn-block" id="btnfiltrar" style="margin-top: 26px;">Buscar</button>
								</fieldset>
							</div>

							<div class="col-lg-2">
								<fieldset class="form-group">
									<button type="button" class="btn btn-primary btn-block" id="btntodo" style="margin-top: 26px;">Limpiar</button>
								</fieldset>
							</div>

						</div>
					</form>
				</div>

				<div class="box-typical box-typical-padding" id="table">
					<table id="ticket_data" class="display table table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="width: 10%;">Identificación</th>
								<th style="width: 25%;">Nombre</th>
								<th class="d-none d-sm-table-cell" style="width: 15%;">Convenio</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Entidad</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Asesor</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Estado</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Estado</th>
								<th class="text-center" style="width: 1%;">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>

			</div>
		</div>

		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="buscarclientes.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>