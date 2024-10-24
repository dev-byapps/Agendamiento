<?php
require_once "../../config/conexion.php";

$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
$usu_grupocom = isset($_SESSION["usu_grupocom"]) ? $_SESSION["usu_grupocom"] : '';
$call = false;

if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/lib/lobipanel/lobipanel.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/lobipanel.min.css">
	<link rel="stylesheet" href="../../public/css/lib/summernote/summernote.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/editor.min.css">
	<link rel="stylesheet" href="../../public/css/separate/elements/cards.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/profile.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/others.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/widgets.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Inicio </title>
	</head>

	<body class="with-side-menu">
		<script>
			var usu_id = "<?php echo $usu_id ?>";
			var usu_perfil = "<?php echo $usu_perfil ?>";
			var usu_grupocom = "<?php echo $usu_grupocom ?>";
		</script>
		<?php require_once "../mainheader/header.php"; ?>
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once "../mainnav/nav.php"; ?>
		<div class="page-content">
			<div class="container-fluid">
				<div class="row">

					<!-- PERFIL -->
					<div class="col-xl-6">
						<div class="m-t-md">
							<div class="box-typical box-typical-padding " style="min-height: 330px;">
								<div class="profile-card" style="padding: 18px 15px 14px;">
									<div class="profile-card-photo">
										<img src="../../public/img/photo-220-1.jpg" alt="">
									</div>
									<div class="profile-card-name" id="nom"></div>
									<div class="profile-card-status semibold"><?php echo $_SESSION["usu_perfil"] ?></div>
									<div class="profile-card-location">Administre sus clientes, operaciones y genere llamadas a contactos efectivos para su gestión.</div>
									<a type="button" class="btn btn-inline btn-primary" href="../perfil/">Perfil</a>
								</div>
							</div>
						</div>
					</div>

					<!-- COMUNICADOS INTERNOS -->
					<div class="col-xl-6">
						<div class="m-t-md">
							<header class="widget-header-dark with-btn">Comunicados Internos <span class="label label-pill label-primary" id="conteo_comuni"></span>
							</header>
							<section class="box-typical box-typical-max-280 scrollable" style="padding: 1px;">
								<div class="box-typical-body">
									<div class="contact-row-list" id="com_internos">
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>

				<?php if ($usu_perfil != "RRHH" && $usu_perfil != "Agente") { ?>
					<div class="row">

						<!-- INDICADORES DE VENTA -->
						<div class="col-xl-6">
							<header class="widget-header-dark with-btn">Indicadores de Ventas

								<?php if ($usu_perfil == "Coordinador") { ?>
									<button type="button" class="widget-header-btn" style="background: #eceeef;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuButton">
										<i class="font-icon font-icon-dots"></i>
									</button>

									<div class="dropdown-menu dropdown-menu-right" id="dato1" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="#" data-value="Grupo">Grupo</a>
										<a class="dropdown-item" href="#" data-value="Individual">Individual</a>
									</div>
								<?php } ?>

							</header>

							<section class="box-typical box-typical-max-280 scrollable">
								<div class="box-typical-body">
									<div class="row" style="background-color:#6F8294;">
										<p style="font-size: 18px; color:#fff; font-weight:500; text-align:center; padding-top:10px;">Desembolsos</p>
										<p style="font-size: 20px; color:#fff; font-weight:500;text-align:center; " id="sumades"></p>
									</div>

									<div class="table-responsive">
										<table id="ventas_data" class="table table-hover" style="margin-top: 0 !important;"></table>
									</div>
								</div>
							</section>
						</div>

						<!-- INDICADORES DE GESTIÓN -->
						<div class="col-xl-6">
							<header class="widget-header-dark with-btn">Indicadores de Gestión
								<button type="button" class="widget-header-btn" style="background: #eceeef;">
									<a href="../dashcomercial/" style="color: inherit; text-decoration: none;">
										<i class="font-icon font-icon-eye"></i>
									</a>
								</button>
							</header>
							<div class="box-typical box-typical-padding" style="padding: 15px 10px;">
								<div class="row">
									<div class="col-sm-6">
										<article class="statistic-box green" style="height: 114px;">
											<div>
												<div class="caption">
													<div>Clientes Interesados</div>
												</div>
												<div class="numberx" id="interesado"></div>
											</div>
										</article>
									</div>
									<div class="col-sm-6">
										<article class="statistic-box yellow" style="height: 114px;">
											<div>
												<div class="caption">
													<div>Clientes en Gestión</div>
												</div>
												<div class="numberx" id="gestiones"></div>
											</div>
										</article>
									</div>
									<div class="col-sm-6">
										<article class="statistic-box blue" style="height: 114px;margin: 0 0 1px;">
											<div>
												<div class="caption">
													<div>Operaciones</div>
												</div>
												<div class="numberx" id="radicado"></div>
												<p id="suma"></p>
											</div>
										</article>
									</div>
									<div class="col-sm-6">
										<section class="widget widget-simple-sm" style="margin: 0 0 1px;">
											<div class="widget-simple-sm-statistic">
												<div class="caption color-green" style="font-size: 12px;">Último cliente registrado:</div><br>
												<div class="caption" id="fecrea"></div> <br>
												<div class="caption color-blue" style="font-size: 12px;">Última operación radicada:</div><br>
												<div class="caption" id="feradicado"></div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				<div class="row">

					<!-- CONTACT CENTER -->
					<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Operativo") { ?>
						<div class="col-xl-6">
							<header class="widget-header-dark with-btn">Contact Center
								<button type="button" class="widget-header-btn" style="background: #eceeef;">
									<a href="../dashccenter/" style="color: inherit; text-decoration: none;">
										<i class="font-icon font-icon-eye"></i>
									</a>
								</button>
							</header>
							<div class="box-typical box-typical-padding">
								<div class="row">
									<div class="col-xl-12">
										<div class="col-sm-6">
											<article class="statistic-box purple" style="height: 114px;">
												<div>
													<div class="caption">
														<div>Campañas Activas</div>
													</div>
													<div class="numberx" id="campact">0</div>
												</div>
											</article>
										</div>
										<div class="col-sm-6">
											<article class="statistic-box purple" style="height: 114px;">
												<div>
													<div class="caption">
														<div>Agenda</div>
													</div>
													<div class="numberx" id="numagenda">0</div>
												</div>
											</article>
										</div>
										<div class="col-sm-12">

											<section class="widget widget-simple-sm">
												<div class="widget-simple-sm-statistic">
													<div class="caption color-purple" style="font-size: 12px;">Ultimo Ingreso a Consola</div>
													<br>
													<div class="caption" id="feconsola"></div>
												</div>
											</section>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<!-- TAREAS -->
					<div class="col-xl-6">
						<header class="widget-header-dark with-btn">Tareas <span class="label label-pill label-primary" id="num_tareas"></span>
							<button type="button" class="widget-header-btn" style="background: #eceeef;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="font-icon font-icon-dots"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#" id="crear_tareas">Crear</a>
								<a class="dropdown-item" href="../tareas/" id="ver_tareas">Ver Todas</a>
							</div>
						</header>
						<section class="box-typical box-typical-max-280 scrollable">
							<div class="box-typical-body">
								<div class="table-responsive" style="overflow-x:inherit;">
									<table class="table table-hover" id="tareas_data" style="margin-top: 0 !important;">
										<thead>
											<tr>
												<th style="width: 45%;">Tarea</th>
												<th style="width: 25%;">Estado</th>
												<th style="width: 15%;">Categoria</th>
												<th style="width: 15%;">Vence</th>
											</tr>
										</thead>

										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</section>
					</div>
				</div>

			</div>
		</div>

		<?php require_once "modalcomunicados.php"; ?>
		<?php require_once "modaltarea.php"; ?>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="home.js"></script>
		<script>
			$(function() {

				/* ============ Datepicker ========================= */

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

				$('#tar_fcierre').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
				});
			});
		</script><!--.Funcion DateTIME-->
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>