<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_nombre = isset($_SESSION["usu_nom"]) ? $_SESSION["usu_nom"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';

if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<script>
		var usu_nombre = '<?php echo $usu_nombre; ?>';
		var usu_id = '<?php echo $usu_id; ?>';
		var perfil = '<?php echo $usu_perfil; ?>';
	</script>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/widgets.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<title>CRM :: Dashboard LLamadas</title>

	<body class="with-side-menu">
		<?php require_once "../mainheader/header.php"; ?>
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once "../mainnav/nav.php"; ?>
		<div class="page-content">
			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
						<li class="active">Dashboard Llamadas</li>
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
								<div class="row" id="viewuser">
									<div class="col-lg-12">
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-label semibold" for="cat_id">Rango Fechas</label>
												<div class="input-group date">
													<input id="daterange" name="daterange" type="text" class="form-control">
													<span class="input-group-addon">
														<i class="font-icon font-icon-calend"></i>
													</span>
												</div>
											</div>
										</div>

										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="prio_id">Campaña</label>
												<select class="select2" id="fil_campana" name="fil_campana" data-placeholder="Seleccionar">
													<option label="Seleccionar"></option>
												</select>
											</fieldset>
										</div>

										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="prio_id">Agente</label>
												<select class="select2" id="fil_agente" name="fil_agente" data-placeholder="Seleccionar">
													<option label="Seleccionar"></option>
												</select>
											</fieldset>
										</div>
									</div>

									<div class="col-lg-12">

										<div class="col-lg-2">
											<fieldset class="form-group">
												<button type="submit" class="btn btn-primary btn-block" id="btnfiltrar" name="btnfiltrar" value="filtrar" disabled>Filtrar</button>
											</fieldset>
										</div>


									</div>
								</div>
							</form>
						</div>

					</div>
				</div>

				<header class="widget-header-dark">Gestión de Llamadas</header>

				<div class="box-typical box-typical-padding">
					<div class="row">
						<div class="col-xl-12">
							<div class="row">

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnInteresado">
										<article class="statistic-box green">
											<div>
												<div class="caption">
													<div>Interesado</div>
												</div>
												<div class="numberx" id="interesado">0</div>
											</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnVolver">
										<article class="statistic-box yellow">
											<div>
												<div class="caption">
													<div>Volver a Llamar</div>
												</div>
												<div class="numberx" id="volver">0</div>
											</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnBuzon">
										<article class="statistic-box yellow">
											<div>
												<div class="caption">
													<div>Buzón de Voz</div>
												</div>
												<div class="numberx" id="buzon">0</div>
											</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnIloca">
										<article class="statistic-box yellow">
											<div>
												<div class="caption">
													<div>Ilocalizado</div>
												</div>
												<div class="numberx" id="ilocalizado">0</div>
											</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnSin">
										<article class="statistic-box yellow">
											<div>
												<div class="caption">
													<div>Sin estado</div>
												</div>
												<div class="numberx" id="sin">0</div>
											</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnNoInteresado">
										<article class="statistic-box purple">
											<div>
												<div class="caption">
													<div>No Interesado</div>
												</div>
												<div class="numberx" id="nointeresado">0</div>
										</article>
									</a>
								</div>

							</div>
						</div>

						<div class="col-xl-12">
							<div class="row">

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnequivocado">
										<article class="statistic-box red">
											<div>
												<div class="caption">
													<div>Numero Equivocado</div>
												</div>
												<div class="numberx" id="equivocado">0</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnFallecido">
										<article class="statistic-box red">
											<div>
												<div class="caption">
													<div>Fallecido</div>
												</div>
												<div class="numberx" id="fallecido">0</div>
										</article>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="../listarllamadas/" id="btnFueraServicio">
										<article class="statistic-box red">
											<div>
												<div class="caption">
													<div>Fuera de Servicio</div>
												</div>
												<div class="numberx" id="fueraservicio">0</div>
										</article>
									</a>
								</div>

							</div>
						</div>
					</div>
				</div>

				<header class="widget-header-dark">Agenda de Llamadas</header>

				<div class="box-typical box-typical-padding">

					<table id="agenda_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 25%;">Campaña</th>
								<th style="width: 30%;">Nombre</th>
								<th class="d-none d-sm-table-cell" style="width: 20%;">Convenio</th>
								<th class="d-none d-sm-table-cell" style="width: 20%;">Agenda</th>
								<th class="text-center" style="width: 5%;">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>



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
					startDate: moment().startOf('month'),
					endDate: moment(),
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
				/* =============== Datepicker =================== */

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
		<script type="text/javascript" src="dashccenter.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>