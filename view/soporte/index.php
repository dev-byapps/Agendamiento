<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {

?>

	<!DOCTYPE html>
	<html>
	<?php require_once "../mainhead/head.php"; ?>

	<title>CRM :: Soporte </title>

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
						<li class="active">Soporte</li>
					</ol>

				</div>
			</header>
			<div class="container-fluid">




				<div class="row">
					<div class="col-xxl-6 col-lg-6 col-xl-6 col-md-6 ">
						<div class="box-typical box-typical-padding">

							<form method="post" id="soporte_form">
								<h5 class="m-t-lg with-border">Solicite Soporte</h5>

								<input type="hidden" id="usu" name="usu" value="<?php echo $_SESSION["usu_nom"] ?>">

								<div class="form-group">
									<label class="form-label semibold" for="cli_cc">Asunto</label>
									<input type="text" class="form-control" placeholder="Asunto" id="asunto_sop" name="asunto">
								</div>

								<div class="form-group">
									<label class="form-label semibold" for="cli_cc">Contácto</label>
									<input type="text" class="form-control" placeholder="Teléfono / Correo" id="contacto_sop" name="contacto">
								</div>

								<div class="form-group">
									<label class="form-label semibold" for="cli_cc">Mensaje</label>
									<textarea rows="4" class="form-control" placeholder="Mensaje" id="mensaje_sop" name="mensaje"></textarea>
								</div>


								<div class="form-group">
									<button id="enviarEmail" type="submit" name="action" value="add" class="btn btn-rounded btn-inline">Enviar</button>
								</div>

							</form>

						</div>
					</div>

				</div>







			</div><!--.container-fluid-->
		</div><!--.page-content-->

		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="soporte.js"></script>

	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>