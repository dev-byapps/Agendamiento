<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Cargar Clientes</title>
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
						<li class="active">Cargar Clientes</li>
					</ol>
				</div>
			</header>
			<div class="container-fluid">
				<div class="row">
					<div class="col-xxl-6 col-lg-6 col-xl-6 col-md-6 ">
						<div class="box-typical box-typical-padding">
							<h5 class="m-t-lg with-border">Cargar Clientes</h5>
							<div class="form-group">
								<input type="file" name="fileTest" multiple="1" id="fileTest" accept=".csv">
							</div>
							<div id="barraP">
								<progress class="progress" value="0" max="100" id="progreso">
									<div class="progress">
										<span class="progress-bar">50%</span>
									</div>
								</progress>
								<div class="uploading-list-item-progress" id="completado">Cargando</div>
								<div class="uploading-list-item-speed" id="contactos">Progreso: <span id="progreso_actual">0</span> de <span id="total_clientes">0</span></div>
							</div>
							<br>
							<div class="form-group">
								<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline" id="cargar">Cargar</button>
							</div>
						</div>
					</div>

					<div class="col-xxl-6 col-lg-6 col-xl-6 col-md-6 ">
						<div class="box-typical box-typical-padding">
							<h5 class="m-t-lg with-border">Cargar Operaciones</h5>
							<div class="form-group">
								<input type="file" name="fileTest" multiple="1" id="fileTest" accept=".csv">
							</div>
							<div id="barraP">
								<progress class="progress" value="0" max="100" id="progreso">
									<div class="progress">
										<span class="progress-bar">50%</span>
									</div>
								</progress>
								<div class="uploading-list-item-progress" id="completado">Cargando</div>
								<div class="uploading-list-item-speed" id="contactos">Progreso: <span id="progreso_actual">0</span> de <span id="total_clientes">0</span></div>
							</div>
							<br>
							<div class="form-group">
								<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline" id="cargar">Cargar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="cargarclientes.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>