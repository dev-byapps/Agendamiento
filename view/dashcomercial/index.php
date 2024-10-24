<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_grupocom = isset($_SESSION["usu_grupocom"]) ? $_SESSION["usu_grupocom"] : '';
$usuPerfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/widgets.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM:: Dashboard Comercial </title>
	</head>

	<body class="with-side-menu">
		<script>
			var usu_grupocom = '<?php echo $usu_grupocom; ?>';
			var usu_id = '<?php echo $usu_id; ?>';
			var usuPerfil = '<?php echo $usuPerfil; ?>';
		</script>
		<?php require_once "../mainheader/header.php"; ?>
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once "../mainnav/nav.php"; ?>
		<div class="page-content">
			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/">
								<span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span>
							</a></li>
						<li class="active">Dashboard Comercial</li>
					</ol>
				</div>
			</header>

			<div class="container-fluid">

				<div class="row">
					<div class="col-xl-12">
						<header class="widget-header-dark with-btn">Filtros
							<button type="button" id="btntodo" class="widget-header-btn" style="background: #eceeef;">
								<i class="font-icon font-icon-refresh"></i>
							</button>
						</header>
						<div class="box-typical box-typical-padding" style="padding: 15px 10px;">
							<form method="post" id="filtros_form">
								<input type="hidden" id="usu_perfil" name="usu_perfil" value="<?php echo $_SESSION["usu_perfil"] ?>">
								<div class="row" id="viewuser">

									<div class="col-lg-12">

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold">Fechas</label>
												<div class="input-group date">
													<input id="daterange" name="daterange" type="text" class="form-control">
													<span class="input-group-addon">
														<i class="font-icon font-icon-calend"></i>
													</span>
												</div>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold">Entidad</label>
												<select class="select2" id="fil_entidad" name="fil_entidad" data-placeholder="Seleccionar">
													<option label="Seleccionar"></option>
												</select>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold">Grupo</label>
												<select class="select2" id="fil_grupo" name="fil_grupo" data-placeholder="Seleccionar">
												</select>

											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold">Asesor</label>
												<select class="select2" id="fil_asesor" name="fil_asesor" data-placeholder="Seleccionar">
													<option label="Seleccionar"></option>
												</select>
											</fieldset>
										</div>

									</div>
								</div>
							</form>
						</div>

					</div>
				</div>

				<div class="col-xl-4" style="padding: 0 10px 0 0;">
					<header class="widget-header-dark" style="background-color: #6F8294; color:white;">Prospectos</header>
					<section class="box-typical box-typical-padding">

						<a id="btnInteresados">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #46C35F;  margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Interesados</div>
									<div class="amount color-green" id="interesados" style="font-size: 25px; font-weight: 600;  "></div>
								</div>
							</div>
						</a>

						<a id="btnCitas">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #46C35F;  margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Citas</div>
									<div class="amount color-green" id="citas" style="font-size: 25px; font-weight: 600;  "></div>
								</div>
							</div>
						</a>

						<a id="btnAnalisis">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #46C35F; margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Analisis</div>
									<div class="amount color-green" id="analisis" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnConsulta">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #F29824; margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Consulta</div>
									<div class="amount color-orange" id="consulta" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnRespuesta">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #F29824; margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Viable</div>
									<div class="amount color-orange" id="respuesta" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnOferta">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #F29824; margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Oferta</div>
									<div class="amount color-orange" id="oferta" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnOperacion">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #00A8FF; margin-bottom: 20px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Operación</div>
									<div class="amount color-blue" id="operacion" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

					</section>
				</div>

				<div class="col-xl-4" style="padding: 0 5px 0 5px;">
					<header class="widget-header-dark" style="background-color: #6F8294; color:white;">Operaciones</header>
					<div class="box-typical box-typical-padding">
						<div class="tbl tbl-item">

							<a id="btnradicacion">
								<div style="background:#46C35F; margin-bottom: 15px; padding: 15px 50px;border-radius: 10px; color:white;">
									<div class="tbl">
										<div class="title" style="font-weight: 600;">Radicados</div>
										<br>
										<div class="amount" id="vRadicacion" style="font-size: 18px;"></div>
										<div class="tbl-cell tbl-cell-progress" id="radicacion" style="text-align:right; align-content: center; font-weight:600; font-size: 25px;"></div>
									</div>
								</div>
							</a>

							<a id="btnproceso">
								<div style="background:#46C35F; margin-bottom: 15px; padding: 15px 50px;border-radius: 10px;color:white;">
									<div class="tbl">
										<div class="title" style="font-weight: 600;">Proceso</div>
										<br>
										<div class="amount" id="vProceso" style="font-size: 18px;"></div>
										<div class="tbl-cell tbl-cell-progress" id="proceso" style="text-align: right; align-content: center; font-weight:600; font-size: 25px;"></div>
									</div>
								</div>
							</a>

							<a id="btnDevoluciones">
								<div style="background:#F29824; margin-bottom: 15px; padding: 15px 50px;border-radius: 10px;color:white;">
									<div class="tbl">
										<div class="title" style="font-weight: 600;">Devoluciones</div>
										<br>
										<div class="amount" id="vDevoluciones" style="font-size: 18px;"></div>
										<div class="tbl-cell tbl-cell-progress" id="devoluciones" style="text-align: right; align-content: center; font-weight:600; font-size: 25px;"></div>
									</div>
								</div>
							</a>

							<a id="btnNegado">
								<div style="background:#FA424A; margin-bottom: 15px; padding: 15px 50px;border-radius: 10px;color:white;">
									<div class="tbl">
										<div class="title" style="font-weight: 600;">Negados</div>
										<br>
										<div class="amount" id="vnegado" style="font-size: 18px;"></div>
										<div class="tbl-cell tbl-cell-progress" id="negado" style="text-align:right; align-content: center; font-weight:600; font-size: 25px;"></div>
									</div>
								</div>
							</a>

							<a id="btnDesembolsados">
								<div style="background:#00A8FF; margin-bottom: 15px; padding: 15px 50px;border-radius: 10px;color:white;">
									<div class="tbl">
										<div class="title" style="font-weight: 600;">Desembolsados</div>
										<br>
										<div class="amount" id="vDesembolsados" style="font-size: 18px;"></div>
										<div class="tbl-cell tbl-cell-progress" id="desembolsados" style="text-align:right; align-content: center; font-weight:600; font-size: 25px;"></div>
									</div>
								</div>
							</a>

						</div>
					</div>
				</div>

				<div class="col-xl-4 " style="padding: 0 0 0 10px;">
					<header class="widget-header-dark" style="background-color: #6F8294; color:white;">Completados</header>
					<div class="box-typical box-typical-padding">

						<a id="btnRetoma">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px purple;  margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Retoma</div>
									<div class="amount color-purple" id="retoma" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnNoViables">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #FA424A;  margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">No Viables</div>
									<div class="amount color-red" id="noviable" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnNoInteresados">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #FA424A;margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">No Interesados</div>
									<div class="amount color-red" id="nointeresado" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

						<a id="btnCerrados">
							<div style="border: 1px solid #d8e2e7; border-left:solid 3px #FA424A; margin-bottom: 15px; padding: 10px 50px; border-radius: 10px; color:black;">
								<div class="tbl">
									<div class="title" style="font-weight: 600;">Cerrados</div>
									<div class="amount color-red" id="cerrado" style="font-size: 25px; font-weight: 600;"></div>
								</div>
							</div>
						</a>

					</div>
				</div>

			</div>

		</div>

		<?php require_once "../mainjs/js.php"; ?>
		<script>
			$(function() {

				$('#daterange').daterangepicker({

					locale: {
						format: 'DD/MM/YYYY',
						applyLabel: "Aplicar",
						cancelLabel: "Cancelar",
						"customRangeLabel": "Personalizado",
						daysOfWeek: [
							"D",
							"L",
							"M",
							"M",
							"J",
							"V",
							"S"
						],
						monthNames: [
							"Enero",
							"Febrero",
							"Marzo",
							"Abril",
							"Mayo",
							"Junio",
							"Julio",
							"Agosto",
							"Septiembre",
							"Octubre",
							"Noviembre",
							"Diciembre"
						],
					},

					startDate: moment().startOf('year'), // 1 de enero del año actual
					endDate: moment(), // Fecha actual
					autoApply: true,

					ranges: {
						'Hoy': [moment(), moment()],
						'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
						'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
						'Este Mes': [moment().startOf('month'), moment().endOf('month')],
						'Mes Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

					},

					"alwaysShowCalendars": true,
				});

				/* ================= Datepicker ==================== */

				$('.datetimepicker-1').datetimepicker({
					widgetPositioning: {
						horizontal: 'right'
					},
					debug: false
				});

				$('.datetimepicker-2').datetimepicker({
					widgetPositioning: {
						horizontal: 'right'
					},
					format: 'LT',
					debug: false
				});
			});
		</script>

		<script type="text/javascript" src="dashcomercial.js"></script>

	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>