<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>

	<!DOCTYPE html>
	<html>
	<?php require_once "../mainhead/head.php"; ?>

	<title>CRM :: Autorizaciones </title>

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
						<li class="active">Dispositivos</li>
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
											<label class="form-label semibold">Usuario</label>
											<select class="select2" id="fil_entidad" name="fil_entidad" data-placeholder="Seleccionar">
												<option label="Seleccionar"></option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-4">
										<fieldset class="form-group">
											<label class="form-label semibold">Estado</label>
											<select class="select2" id="fil_grupo" name="fil_grupo" data-placeholder="Seleccionar">
												<option>Activo</option>
												<option>Inactivo</option>
												<option>Pendiente</option>
											</select>
										</fieldset>
									</div>

									<div class="col-lg-2">
										<button class="btn btn-primary btn-block" id="btntodo" style="margin-top: 27px;">Limpiar</button>
									</div>

								</div>
							</div>
						</form>
					</div>
				</section>

				<div class="box-typical box-typical-padding" id="table">

					<table id="dispositivos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 25%;">Usuario</th>
								<th style="width: 25%;">Dispositivo</th>
								<th style="width: 20%;">Fecha</th>
								<th style="width: 20%;">Estado</th>
								<th class="text-center" style="width: 10%;">Acciones</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>

			</div><!--.container-fluid-->
		</div><!--.page-content-->

		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="dispositivos.js"></script>

	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>