<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
$ip = isset($_SESSION["client_ip"]) ? $_SESSION["client_ip"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<script>
		var usuPerfil = '<?php echo $usu_perfil; ?>';
		var usu_id = '<?php echo $usu_id; ?>';
		var ip = '<?php echo $ip; ?>';
	</script>
	<link rel="stylesheet" href="../../public/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/datatables-net.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/activity.min.css">
	<link rel="stylesheet" href="../../public/css/lib/lobipanel/lobipanel.min.css">
	<link rel="stylesheet" href="../../public/css/separate/vendor/lobipanel.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/files.min.css">
	<link rel="stylesheet" href="../../public/css/lib/summernote/summernote.css" />
	<link rel="stylesheet" href="../../public/css/separate/pages/editor.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/widgets.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<?php require_once "../mainhead/head.php"; ?>
	<link rel="stylesheet" href="../../public/css/separate/pages/profile.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/project.min.css">
	<title>CRM :: Detalle Cliente </title>
	<style>
		.whatsapp-dropdown {
			position: absolute;
			display: inline-block;
			top: -5px;
			right: -2px;
		}

		.whatsapp-dropdown-content {
			display: none;
			position: absolute;
			top: 100%;
			right: 0;
			background-color: #f9f9f9;
			min-width: 80px;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
			border-radius: 4px;
		}

		.whatsapp-dropdown-content a {
			color: black;
			padding: 8px 12px;
			text-decoration: none;
			display: flex;
			font-size: 14px;
			/* Ajusta el tamaño del texto si es necesario */
			width: 80px;
			/* Establece un ancho fijo para los botones */
			box-sizing: border-box;
			/* Asegura que el padding se incluya en el ancho total */
		}

		.whatsapp-dropdown-content a i {
			margin-left: 8px;
			font-size: 14px;
			/* Ajusta el tamaño del icono si es necesario */
		}

		.whatsapp-dropdown-content a:hover {
			background-color: #f1f1f1;
		}

		.whatsapp-dropdown:hover .whatsapp-dropdown-content {
			display: block;
		}

		.whatsapp-btn {
			background-color: #25D366; //Color de fondo de WhatsApp
			border: none;
			color: white;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 12px;
			margin: 4px 2px;
			cursor: pointer;
			border-radius: 50%;
			position: absolute;
			top: -5px;
			right: -2px;
		}

		.whatsapp-dropdown-content a.disabled {
			pointer-events: none;
			/* Evita que el enlace sea clickeable */
			color: #ccc;
			/* Cambia el color del texto para que parezca deshabilitado */
			cursor: not-allowed;
			/* Cambia el cursor para indicar que no es clickeable */
		}
	</style>
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
						<li class="active">Detalle Cliente</li>
					</ol>
				</div>
			</header>

			<div class="container-fluid">

				<!-- DETALLE CLIENTE -->
				<section class="box-typical proj-page">
					<section class="proj-page-section">

						<header class="proj-page-subtitle with-del p-b-0">
							<h5 class="with-border" style="font-size: 1.25rem; font-weight: 400;">Datos del Cliente</h5>
							<!-- <button type="button" class="btn btn-inline" style="position: absolute; top: -5px;right: -2px;" id="pdfcliente"><i class="fa fa-floppy-o"></i></button> -->
							<div class="whatsapp-dropdown">
								<button type="button" class="btn btn-inline whatsapp-btn" id="whatsapp"><i class="fa fa-whatsapp"></i></button>
								<div class="whatsapp-dropdown-content">
									<a href="#" id="tel" onclick="handleClick('tel1')" class="disabled"><i class="fa fa-phone-volume"></i>Tel1</a>
									<a href="#" id="telalter" onclick="handleClick('tel2')" class="disabled"><i class="fa fa-phone-volume"></i>Tel2</a>
								</div>
							</div>
						</header>
						<div class="row">
							<br>

							<div class="col-lg-2">
								<div class="profile-card" style="padding: 5px; margin: 5px;">
									<div class="profile-card-photo">
										<img src="../../public/img/photo-220-1.jpg" alt="">
									</div>
								</div>
							</div>

							<div class="col-lg-10">
								<div class="row">
									<div class="col-lg-12">
										<label class="form-label semibold" for="est_laboral" id="Identificacion"></label>
										<label class="form-label semibold" for="est_laboral" style="font-size: 18px;" id="Nombre"></label>
										<label class="form-label semibold" for="est_laboral" id="Convenio"></label>
									</div>
								</div>

								<div class="row" style="padding-right: 20px;" id="dato">
									<label class="col-lg-2 form-label semibold" for="cli_estado">Estado </label>
									<div class="col-lg-3 dropdown dropdown-status  "><button class="btn btn-default dropdown-toggle" style="margin-bottom: 5px;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="Estado">Interesado</button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="#" data-value="Interesado">INTERESADO</a>
											<a class="dropdown-item" href="#" data-value="Citas">CITAS</a>
											<a class="dropdown-item" href="#" data-value="Analisis">ANALISIS</a>
											<a class="dropdown-item" href="#" data-value="Consulta">CONSULTA</a>
											<a class="dropdown-item" href="#" data-value="Oferta">OFERTA</a>
											<a class="dropdown-item" href="#" data-value="Retoma">RETOMA</a>
											<a class="dropdown-item" href="#" data-value="No interesado">NO INTERESADO</a>
											<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador") { ?>
												<a class="dropdown-item" href="#" data-value="No viable">NO VIABLE</a>
												<a class="dropdown-item" href="#" data-value="Viable">VIABLE</a>
												<a class="dropdown-item" href="#" data-value="Operacion">OPERACION</a>
												<a class="dropdown-item" href="#" data-value="Cerrado">CERRADO</a>
												<?php } ?>E
										</div>
									</div>

									<label class="col-lg-2 form-label semibold">Asesor </label>
									<div class="col-lg-5" style="margin-bottom: 5px;">
										<span class="label label-default" id="Asesor"></span>
									</div>
								</div>

								<div class="row" style="padding-right: 20px;">
									<label class="col-sm-5 form-label semibold" style="font-size: 13px; margin-top: 5px;" id="FeCreacion">Fecha Creación: </label>
									<label class="col-sm-7 form-label semibold" style="font-size: 13px; margin-top: 5px;" id="FeActualizacion">Fecha Actualización: </label>
								</div>
							</div>
						</div>
					</section>
				</section>

				<!-- MAS DETALLE -->
				<section class="widget widget-accordion" id="accordion" role="tablist" aria-multiselectable="true">
					<article class="panel">
						<div class="panel-heading" role="tab" id="headingOne">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed" id="mas" disabled>
								Mas Información
								<i class="font-icon font-icon-arrow-down"></i>
							</a>
						</div>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
							<form action="add" id="form_cli">
								<input type="hidden" id="cli_id" name="cli_id" value="<?php echo htmlspecialchars($_GET['i'] ?? ''); ?>">
								<div class="panel-collapse-in">
									<div class="row">
										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="tipo_doc">Tipo Doc.</label>
												<select id="tipo_doc" name="tipo_doc" class="form-control" disabled>
													<option val="CC">CC</option>
												</select>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_cc">Identificación</label>
												<input type="text" class="form-control" id="cli_cc" name="cli_cc" placeholder="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required maxlength="15" readonly>
											</fieldset>
										</div>

										<div class="col-lg-6">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_nombre">Nombre Completo</label>
												<input type="text" class="form-control" id="cli_nombre" name="cli_nombre" placeholder="" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '').toUpperCase()" required readonly>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="fec_nac">Fecha Nacimiento</label>
												<input type="text" class="form-control" id="fec_nac" name="fec_nac" placeholder="" wfd-id="id1" readonly>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_edad">Edad</label>
												<input type="text" class="form-control" id="cli_edad" name="cli_edad" placeholder="" readonly>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_telefono">Teléfono</label>
												<div style="display: flex; align-items: center;">
													<input type="text" class="form-control" id="cli_telefono" name="cli_telefono" placeholder="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" required readonly style="flex: 1; margin-right: 5px;">
												</div>
											</fieldset>
										</div>




										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="tel_alternativo">Tel. Alternativo</label>
												<input type="text" class="form-control" id="tel_alternativo" name="tel_alternativo" placeholder="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="12" readonly>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_mail">Correo</label>
												<input type="email" class="form-control" id="cli_mail" name="cli_mail" placeholder="info@correo.com" size="30" readonly>
											</fieldset>
										</div>
										<div class="col-lg-6">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_dir">Dirección</label>
												<input type="text" class="form-control" id="cli_dir" name="cli_dir" size="30" oninput="this.value = this.value.toUpperCase()" readonly>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_ciudad">Ciudad</label>
												<select class="form-control" id="cli_ciudad" name="cli_ciudad" style="width: 100%;" disabled>
													<option value="" disabled selected>Escribe una ciudad</option>
												</select>
												<ul id="suggestions" class="list-group" style="display: none; position: absolute; z-index: 1000; width: 100%; text-transform: uppercase;"></ul>
											</fieldset>
										</div>

										<div class="col-lg-3">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_dep">Departamento</label>
												<input type="text" class="form-control" id="cli_dep" name="cli_dep" placeholder="" size="30" style="text-transform: uppercase;" readonly>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_entidad">Entidad</label>
												<select id="cli_entidad" name="cli_entidad" class="form-control" disabled>
												</select>
											</fieldset>
										</div>

										<div class="col-lg-8">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_convenio">Convenio</label>
												<select class="form-control" id="cli_convenio" name="cli_convenio" style="width: 100%;" disabled>
													<option value="" disabled selected>Escribe unconvenio</option>
												</select>
												<ul id="suggestions2" class="list-group" style="display: none; position: absolute; z-index: 1000; width: 100%; text-transform: uppercase;"></ul>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="est_laboral">Estado Laboral</label>
												<select id="est_laboral" name="est_laboral" class="form-control" disabled>
													<option></option>
													<option>ACTIVO</option>
													<option>PENSIONADO</option>
													<option>PENSIONADO/ACTIVO</option>
												</select>
											</fieldset>
										</div>

										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="tipo_contrato">Tipo de Contrato</label>
												<select id="tipo_contrato" name="tipo_contrato" class="form-control" disabled>
													<option></option>
													<option>FIJO</option>
													<option>INDEFINIDO</option>
													<option>CARRERA ADMIN</option>
													<option>LIBRE NOMBRAMIENTO</option>
													<option>REOMOCION</option>
													<option>PROVISIONAL</option>
													<option>OTRO</option>

												</select>
											</fieldset>
										</div>

										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="cli_cargo">Cargo</label>
												<input type="text" class="form-control" id="cli_cargo" name="cli_cargo" placeholder="" size="40" readonly>
											</fieldset>
										</div>

									</div>

									<div class="row">
										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="tiem_servicio">Fecha / Tiempo</label>
												<input type="text" class="form-control" id="tiem_servicio" name="tiem_servicio" placeholder="" size="30" readonly>
											</fieldset>
										</div>

										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="tipo_pension">Tipo de Pensión</label>
												<select id="tipo_pension" name="tipo_pension" class="form-control" disabled>
													<option value=""></option>
													<option value="Vejez">VEJEZ</option>
													<option value="Invalidez">INVALIDEZ</option>
													<option value="Sustitución">SUSTITUCION</option>
												</select>
											</fieldset>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="contacto">Toma de Contacto</label>
												<select id="contacto" name="contacto" class="form-control" disabled>
													<option></option>
												</select>
											</fieldset>
										</div>
										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="agente">Agente Contacto</label>
												<select id="agente" name="agente" class="form-control" disabled>
													<option></option>
												</select>
											</fieldset>
										</div>
										<div class="col-lg-4">
											<fieldset class="form-group">
												<label class="form-label semibold" for="asesor">Asesor Comercial</label>
												<select id="asesor" name="asesor" class="form-control" disabled>
													<option></option>
												</select>
											</fieldset>
										</div>

									</div>

									<div class="row" id="btns">
										<div class="col-lg-12">
											<button type="button" class="btn btn-inline" id="editar">Editar</button disablet>
											<button type="button" class="btn btn-inline" id="guardar" disabled>Guardar</button>
										</div>
									</div>

								</div>
							</form>
						</div>
					</article>
				</section>

				<!-- OPERACIONES -->
				<section class="box-typical proj-page">
					<section class="proj-page-section">
						<header class="proj-page-subtitle with-del p-b-0">
							<h5 class="with-border" style="font-size: 1.25rem; font-weight: 400;">Operaciones</h5>
							<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador") { ?>
								<button type="button" class="btn btn-inline" style="position: absolute; top: -5px;right: -2px;" id="NuevaOperacion" disabled><i class="fa fa-plus-circle"></i> Operación</button>
							<?php } ?>
						</header>

						<table id="operaciones_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
							<thead>
								<tr>
									<th style="width: 10%;">Numero</th>
									<th style="width: 20%;">Operación</th>
									<th class="d-none d-sm-table-cell" style="width: 20%;">Entidad</th>
									<th class="d-none d-sm-table-cell" style="width: 10%;">Monto Radicado</th>
									<th class="d-none d-sm-table-cell" style="width: 20%;">Estado</th>
									<th id="th-fecha" class="d-none d-sm-table-cell" style="width: 10%;"></th>
									<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador") { ?>
										<th class="text-center" style="width: 10%;">Acciones</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

					</section><!--Operaciones-->
				</section>

				<!-- COMENTARIOS -->
				<section class="box-typical proj-page">
					<section class="proj-page-section">
						<header class="proj-page-subtitle with-del">
							<h5 class="with-border" style="font-size: 1.25rem; font-weight: 400;">Comentarios</h5>
							<button type="button" class="btn btn-inline" style="position: absolute; top: -5px;right: 135px;" id="resconsult"><i class="fa fa-search-plus"></i></button>
							<button type="button" class="btn btn-inline" style="position: absolute; top: -5px;right: -2px;" id="addcoment"><i class="fa fa-plus-circle"></i> Comentario</button>
						</header>
						<section class="activity-line" id="lblcomentarios"></section>
					</section>
				</section>
				<?php
				// <!-- TAREAS -->
				// <section class="box-typical proj-page">
				// 	<section class="proj-page-section">
				// 		<header class="proj-page-subtitle with-del p-b-0">
				// 			<h5 class="with-border" style="font-size: 1.25rem; font-weight: 400;">Tareas</h5>
				// 			<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador") { 
				// 				<button type="button" class="btn btn-inline" style="position: absolute; top: -5px;right: -2px;" id="NuevaTarea"><i class="fa fa-plus-circle"></i> Tarea</button>
				// 			<?php } 
				// 		</header>


				// 		<table id="tareas_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
				// 			<thead>
				// 				<tr>
				// 					<th style="width: 30%;">Tarea</th>
				// 					<th class="d-none d-sm-table-cell" style="width: 5%;">Asignado</th>
				// 					<th class="d-none d-sm-table-cell" style="width: 5%;">Prioridad</th>
				// 					<th class="d-none d-sm-table-cell" style="width: 10%;">Categoria</th>
				// 					<th class="d-none d-sm-table-cell" style="width: 10%;">Estado</th>
				// 					<th class="d-none d-sm-table-cell" style="width: 10%;">Vencimiento</th>
				// 					<th style="width: 1%;">Acciones</th>
				// 				</tr>
				// 			</thead>
				// 			<tbody></tbody>
				// 		</table>

				// 	</section><!--Operaciones-->
				// </section>
				?>

				<!-- DOCUMENTOS -->
				<section class="box-typical proj-page">
					<section class="proj-page-section">
						<header class="proj-page-subtitle with-del p-b-0">
							<h5 class="with-border" style="font-size: 1.25rem; font-weight: 400;">Documentos</h5>
							<button type="button" class="btn btn-inline" style="position: absolute; top: -5px;right: -2px;" id="addDoc"><i class="fa fa-plus-circle"></i> Documento</button>
						</header>
						<br>
						<div class="col-xl-3" style="padding: 5px;">
							<div class="box-typical lobipanel">
								<header class="box-typical-header panel-heading">
									<h3 class="panel-title" style="max-width:none;">Categorias</h3>
									<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador") { ?>
										<div class="dropdown dropdown-menu-right">
											<a id="btn_newcat" title="Crear">
												<i class="panel-control-icon glyphicon glyphicon-plus"></i>
											</a>
										</div>
									<?php } ?>
								</header>
								<div class="files-manager">
									<ul class="files-manager-side-list">

									</ul>
								</div>
							</div>
						</div>

						<div class="col-xl-9" style="padding: 5px;">
							<div class="box-typical lobipanel col-xl-12 p-a-0">
								<header class="box-typical-header panel-heading">
									<h3 class="panel-title" style="max-width: calc(100% - 50px);" id="nomcat">
									</h3>
									<?php if ($usu_perfil != "Asesor" && $usu_perfil != "Coordinador") { ?>
										<div class="dropdown dropdown-menu-right">
											<a id="edit-icon" data-func="editaenombre" data-tooltip="Editar" data-toggle="tooltip" data-title="Editar" data-placement="bottom" data-original-title="" title=""><i class="panel-control-icon glyphicon-pencil glyphicon" style="margin-right: 10px;"></i></a>
											<a id="eliminarcat" data-func="eliminar" data-tooltip="Eliminar" data-toggle="tooltip" data-title="Eliminar" data-placement="bottom" data-original-title="" title=""><i class="panel-control-icon glyphicon glyphicon-trash"></i></a>
										</div>
									<?php } ?>
								</header>

								<table id="entidad_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
									<thead>
										<tr>
											<th style="width: 50%;">Nombre</th>
											<th style="width: 15%;">Creado por</th>
											<th style="width: 15%;">Fecha</th>
											<th class="text-center" style="width: 20%;">Acciones</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>

						<div class="row card-user-grid">
							<div id="container"></div>
						</div>
						<br>


					</section>
				</section>

			</div>

		</div>

		<?php require_once "modaloperaciones.php"; ?>
		<?php require_once "modalcomentarios.php"; ?>
		<?php require_once "modalconsulta.php"; ?>
		<?php require_once "modaldocumentos.php"; ?>
		<?php require_once "modalcategoria.php"; ?>
		<?php require_once "modaltarea.php"; ?>

		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="detallecliente.js"></script>

		<script>
			$(function() {
				// Obtener la fecha actual
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

				$('#ope_festado').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
				});

				$('#ope_feradicacion').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
				});

				$('#ope_fcierre').daterangepicker({
					singleDatePicker: true,
					showDropdowns: true,
					locale: localeConfig
				});
			});
		</script>
	</body>

	</html>
	<script>
		var usu_id = '<?php echo $usu_id; ?>';
	</script>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>