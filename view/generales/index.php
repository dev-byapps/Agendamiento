<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {
?>

	<!DOCTYPE html>
	<html>
	<?php require_once "../mainhead/head.php"; ?>

	<title>CRM :: Configuraciones Generales </title>

	</head>

	<body class="with-side-menu">

		<link rel="stylesheet" href="../../public/css/lib/jquery-minicolors/jquery.minicolors.css">
		<link rel="stylesheet" href="../../public/css/separate/vendor/jquery.minicolors.min.css">

		<?php require_once "../mainheader/header.php"; ?>

		<div class="mobile-menu-left-overlay"></div>

		<?php require_once "../mainnav/nav.php"; ?>

		<div class="page-content">

			<header class="page-content-header">
				<div class="container-fluid">
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="../home/"><span class="material-symbols-rounded" style="color:#5B80A3; position:static; font-size:20px">home</span></a></li>
						<li class="active">Configuraciones Generales</li>
					</ol>

				</div>
			</header>

			<div class="container-fluid">
				<div class="box-typical box-typical-padding">

					<section class="tabs-section">
						<div class="tabs-section-nav tabs-section-nav-icons">
							<div class="tbl">
								<ul class="nav" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" href="#tab-1" role="tab" data-toggle="tab" aria-expanded="true">
											<span class="nav-link-in">
												<i class="fa fa-gear"></i>
												Configuración General
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#tab-2" role="tab" data-toggle="tab" aria-expanded="true">
											<span class="nav-link-in">
												<i class="fa fa-picture-o"></i>
												Estilos
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#tab-3" role="tab" data-toggle="tab" aria-expanded="true">
											<span class="nav-link-in">
												<i class="font-icon font-icon-award"></i>
												Legal
											</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#tab-4" role="tab" data-toggle="tab" aria-expanded="true">
											<span class="nav-link-in">
												<i class="font-icon font-icon-help"></i>
												Utilidades
											</span>
										</a>
									</li>

									<li class="nav-item">
										<a class="nav-link" href="#tab-5" role="tab" data-toggle="tab" aria-expanded="true">
											<span class="nav-link-in">
												<i class="font-icon font-icon-lock"></i>
												Seguridad
											</span>
										</a>
									</li>


								</ul>
							</div>
						</div>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab-1" aria-expanded="true">
								<section class="card">
									<header class="card-header card-header-lg">
										</i> Datos de la empresa
									</header>
									<div class="card-block">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Nombre</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="1" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Razón social</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="2" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">NIT</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="3" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Teléfono</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="4" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Celular</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="5" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Email</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="6" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Página web</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="18" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Dirección</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="7" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Ciudad</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="8" type="text">
												</div>
											</div>
										</div>
									</div>
								</section>

								<section class="card">
									<header class="card-header card-header-lg">
										</i> Contácto Administrativo
									</header>
									<div class="card-block">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Nombre</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="28" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Cargo</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="29" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Teléfono</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="30" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Celular</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="30" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Email</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="31" type="text">
												</div>
											</div>
										</div>
									</div>
								</section>
								<section class="card">
									<header class="card-header card-header-lg">
										</i> Contácto Contable
									</header>
									<div class="card-block">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Nombre</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="28" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Cargo</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="29" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Teléfono</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="30" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Celular</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="30" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Email</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="31" type="text">
												</div>
											</div>
										</div>
									</div>
								</section>
								<section class="card">
									<header class="card-header card-header-lg">
										</i> Contácto Técnico
									</header>
									<div class="card-block">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Nombre</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="28" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Cargo</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="29" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Teléfono</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="30" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Celular</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="30" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Email</label>
												<div class="form-control-wrapper">
													<input class="form-control update" data-id="31" type="text">
												</div>
											</div>
										</div>
										<br clear="all">
										<div align="center" id="save-button">
											<button class="btn btn-default"><i class="fa fa-refresh"></i> Guardar configuración</button>
										</div>
									</div>
								</section>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab-2" aria-expanded="true">
								<section class="card">
									<header class="card-header card-header-lg">
										Opciones de diseño
									</header>

									<div class="card-block">
										<div class="col-md-12">
											<div class="form-group row">
												<label for="exampleSelect" class="col-sm-4 form-control-label">
													<font style="vertical-align: inherit;">
														<font style="vertical-align: inherit;">Modo</font>
													</font>
												</label>
												<div class="col-sm-8">
													<select id="exampleSelect" class="form-control">
														<option>
															<font style="vertical-align: inherit;">
																<font style="vertical-align: inherit;">Claro</font>
															</font>
														</option>
														<option>
															<font style="vertical-align: inherit;">
																<font style="vertical-align: inherit;">Oscuro</font>
															</font>
														</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group row">
												<label for="hue-demo" class="col-sm-4 form-control-label">
													<font style="vertical-align: inherit;">
														<font style="vertical-align: inherit;">Color NAV</font>
													</font>
												</label>
												<div class="col-sm-8">
													<input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="#ff6161">
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group row">
												<label for="exampleSelect" class="col-sm-4 form-control-label">
													<font style="vertical-align: inherit;">
														<font style="vertical-align: inherit;">Color HEAD</font>
													</font>
												</label>
												<div class="col-sm-8">
													<input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="#ff6161">
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group row">
												<label for="exampleSelect" class="col-sm-4 form-control-label">
													<font style="vertical-align: inherit;">
														<font style="vertical-align: inherit;">Color LOGIN</font>
													</font>
												</label>
												<div class="col-sm-8">
													<input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="#ff6161">
												</div>
											</div>
										</div>
								</section>
								<div class="col-md-4">
									<section class="card">
										<header class="card-header card-header-lg">
											<i class="fa fa-image"></i> Panel (273x100px)
										</header>
										<div class="card-block">
											<div align="center">
												<br>
												<img src="" class="img-logo-panel" style="width:100%; max-width:273px;">
												<br><br>
												<button class="btn btn-success" data-toggle="modal" data-target="#modal-logo-panel">Modificar</button>
											</div>
											<div class="modal fade" id="modal-logo-panel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
																<i class="font-icon-close-2"></i>
															</button>
															<h4 class="modal-title">Subir logo Panel (273x100px)</h4>
														</div>
														<div class="modal-upload menu-bottom">
															<div class="modal-upload-cont">
																<div class="modal-upload-cont-in" style="height:auto;">
																	<div class="tab-content">
																		<div role="tabpanel" class="tab-pane active">
																			<div class="modal-upload-body scrollable-block">
																				<div class="uploading-container">
																					<div class="drop-zone drop-for-logo-panel dz-clickable" style="width:100%">
																						<div style="margin-top:34px;"></div>
																						<i class="drop-for-logo-panel font-icon font-icon-cloud-upload-2 dz-clickable"></i>
																						<div class="drop-for-logo-panel drop-zone-caption dz-clickable">Click o suelta una imagen .PNG de 273x100px aquí...</div>
																					</div>
																					<div class="preview-logo-panel" style="display:none;"></div>
																					<script>
																						$(".drop-for-logo-panel").dropzone({
																							url: dominio + "base/upload-logo/1/",
																							paramName: "file",
																							maxFilesize: 4,
																							parallelUploads: 1,
																							acceptedFiles: 'image/png',
																							previewsContainer: '.preview-logo-panel',
																							accept: function(file, done) {
																								$('.drop-zone-logo-panel').html('<div align="center" style="margin-top:58px;"><img src="https://app.intranetzenter.com/build/img/loading.gif" /></div>');
																								done();
																							},
																							success: function(data) {
																								$('.img-logo-panel').attr('src', 'https://app.intranetzenter.com/uploads/demo/img/logo/' + data.xhr.response + '?time=' + data.lastModified);
																								$('.drop-for-logo-panel').html(`
																						<div style="margin-top:34px;"></div>
																						<i class="font-icon font-icon-cloud-upload-2"></i>
																						<div class="drop-zone-caption">Click o suelta una imagen .png aquí...</div>
																					`);
																								$('.modal-close').click();
																							}
																						});
																					</script>
																				</div><!--.uploading-container-->
																			</div><!--.modal-upload-body-->
																		</div><!--.tab-pane-->
																	</div><!--.tab-content-->
																</div><!--.modal-upload-cont-in-->
															</div><!--.modal-upload-cont-->
														</div>
													</div>
												</div>
											</div><!--.modal-->
										</div>
									</section>
								</div>
								<div class="col-md-4">
									<section class="card">
										<header class="card-header card-header-lg">
											<i class="fa fa-image"></i> Móvil (79x64px)
										</header>
										<div class="card-block">
											<div align="center">
												<br>
												<img src="" class="img-logo-movil" style="width:100%; max-width:79px;">
												<br><br>
												<button class="btn btn-success" data-toggle="modal" data-target="#modal-logo-movil">Modificar</button>
											</div>
											<div class="modal fade" id="modal-logo-movil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
																<i class="font-icon-close-2"></i>
															</button>
															<h4 class="modal-title">Subir logo Móvil (79x64px)</h4>
														</div>
														<div class="modal-upload menu-bottom">
															<div class="modal-upload-cont">
																<div class="modal-upload-cont-in" style="height:auto;">
																	<div class="tab-content">
																		<div role="tabpanel" class="tab-pane active">
																			<div class="modal-upload-body scrollable-block">
																				<div class="uploading-container">
																					<div class="drop-zone drop-for-logo-movil dz-clickable" style="width:100%">
																						<div style="margin-top:34px;"></div>
																						<i class="drop-for-logo-movil font-icon font-icon-cloud-upload-2 dz-clickable"></i>
																						<div class="drop-for-logo-movil drop-zone-caption dz-clickable">Click o suelta una imagen .PNG de 79x64px aquí...</div>
																					</div>
																					<div class="preview-logo-movil" style="display:none;"></div>
																					<script>
																						$(".drop-for-logo-movil").dropzone({
																							url: dominio + "base/upload-logo/2/",
																							paramName: "file",
																							maxFilesize: 4,
																							parallelUploads: 1,
																							acceptedFiles: 'image/png',
																							previewsContainer: '.preview-logo-movil',
																							accept: function(file, done) {
																								$('.drop-zone-logo-movil').html('<div align="center" style="margin-top:58px;"><img src="https://app.intranetzenter.com/build/img/loading.gif" /></div>');
																								done();
																							},
																							success: function(data) {
																								$('.img-logo-movil').attr('src', 'https://app.intranetzenter.com/uploads/demo/img/logo/' + data.xhr.response + '?time=' + data.lastModified);
																								$('.drop-for-logo-movil').html(`
																						<div style="margin-top:34px;"></div>
																						<i class="font-icon font-icon-cloud-upload-2"></i>
																						<div class="drop-zone-caption">Click o suelta una imagen .png aquí...</div>
																					`);
																								$('.modal-close').click();
																							}
																						});
																					</script>
																				</div><!--.uploading-container-->
																			</div><!--.modal-upload-body-->
																		</div><!--.tab-pane-->
																	</div><!--.tab-content-->
																</div><!--.modal-upload-cont-in-->
															</div><!--.modal-upload-cont-->
														</div>
													</div>
												</div>
											</div><!--.modal-->
										</div>
									</section>
								</div>
								<div class="col-md-4">
									<section class="card">
										<header class="card-header card-header-lg">
											<i class="fa fa-image"></i> Login (100x100px)
										</header>
										<div class="card-block">
											<div align="center">
												<br>
												<img src="" class="img-pagina-login" style="width:100%; max-width:100px;">
												<br><br>
												<button class="btn btn-success" data-toggle="modal" data-target="#modal-pagina-login">Modificar</button>
											</div>
											<div class="modal fade" id="modal-pagina-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
																<i class="font-icon-close-2"></i>
															</button>
															<h4 class="modal-title">Subir logo Login (100x100px)</h4>
														</div>
														<div class="modal-upload menu-bottom">
															<div class="modal-upload-cont">
																<div class="modal-upload-cont-in" style="height:auto;">
																	<div class="tab-content">
																		<div role="tabpanel" class="tab-pane active">
																			<div class="modal-upload-body scrollable-block">
																				<div class="uploading-container">
																					<div class="drop-zone drop-for-pagina-login dz-clickable" style="width:100%">
																						<div style="margin-top:34px;"></div>
																						<i class="drop-for-pagina-login font-icon font-icon-cloud-upload-2 dz-clickable"></i>
																						<div class="drop-for-pagina-login drop-zone-caption dz-clickable">Click o suelta una imagen .PNG de 100x100px aquí...</div>
																					</div>
																					<div class="preview-pagina-login" style="display:none;"></div>
																					<script>
																						$(".drop-for-pagina-login").dropzone({
																							url: dominio + "base/upload-logo/3/",
																							paramName: "file",
																							maxFilesize: 4,
																							parallelUploads: 1,
																							acceptedFiles: 'image/png',
																							previewsContainer: '.preview-pagina-login',
																							accept: function(file, done) {
																								$('.drop-zone-pagina-login').html('<div align="center" style="margin-top:58px;"><img src="https://app.intranetzenter.com/build/img/loading.gif" /></div>');
																								done();
																							},
																							success: function(data) {
																								$('.img-pagina-login').attr('src', 'https://app.intranetzenter.com/uploads/demo/img/logo/' + data.xhr.response + '?time=' + data.lastModified);
																								$('.drop-for-pagina-login').html(`
																						<div style="margin-top:34px;"></div>
																						<i class="font-icon font-icon-cloud-upload-2"></i>
																						<div class="drop-zone-caption">Click o suelta una imagen .png aquí...</div>
																					`);
																								$('.modal-close').click();
																							}
																						});
																					</script>
																				</div><!--.uploading-container-->
																			</div><!--.modal-upload-body-->
																		</div><!--.tab-pane-->
																	</div><!--.tab-content-->
																</div><!--.modal-upload-cont-in-->
															</div><!--.modal-upload-cont-->
														</div>
													</div>
												</div>
											</div><!--.modal-->
										</div>
									</section>
								</div>
								<br clear="all">
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab-3" aria-expanded="true">

								<section class="card">
									<header class="card-header card-header-lg">
										Textos Legales
									</header>
									<div class="card-block">
										<div class="col-md-12">
											<div class="form-group">
												<label class="form-label" for="nombre">Aviso Legal</label>
												<div class="form-control-wrapper">
													<textarea style="height:400px" class="form-control update" data-id="49" type="text"></textarea>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label class="form-label" for="nombre">Política de Privacidad</label>
												<div class="form-control-wrapper">
													<textarea style="height:400px" class="form-control update" data-id="50" type="text"></textarea>
												</div>
											</div>
										</div>
										<br clear="all">
										<div align="center" id="save-button">
											<button class="btn btn-default"><i class="fa fa-refresh"></i> Guardar configuración</button>
										</div>
									</div>
								</section>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab-4" aria-expanded="true">
								<section class="card">
									<header class="card-header card-header-lg">
										Configuración SMTP
									</header>
									<div class="card-block">
										<div class="col-md-12">
											<p>Necesitamos la configuración SMTP de una cuenta de correo para enviar mensajes. Configura una cuenta de correo a continuación:</p>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Servidor SMTP</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="1">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Puerto</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="2">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Usuario SMTP</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="3">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Contraseña</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="password" data-id="4">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Nombre de emisor</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="5">
												</div>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label" for="nombre">Responder a</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="7">
												</div>
											</div>
										</div>
										<br clear="all">
										<div align="center" id="comprobar-smtp-button">
											<button class="btn btn-default comprobar-smtp"><i class="fa fa-refresh"></i> Comprobar configuración</button>
										</div>
										<div align="center" style="display:none;" id="comprobar-smtp-loading">
											<img src="/public/img/loading.gif">
										</div>
									</div>
								</section>
								<section class="card">
									<header class="card-header card-header-lg">
										Configuración SIP
									</header>
									<div class="card-block">
										<div class="col-md-12">
											<p>Necesitamos la configuración SIP para realizar llamadas. Configura una cuenta SIP a continuación:</p>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label" for="nombre">Servidor SIP</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="1">
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label" for="nombre">Puerto</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="2">
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label" for="nombre">AMI Usuario</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="2">
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label" for="nombre">AMI Contraseña</label>
												<div class="form-control-wrapper">
													<input class="form-control update-email-config" type="text" data-id="2">
												</div>
											</div>
										</div>
										<br clear="all">
										<div align="center" id="comprobar-smtp-button">
											<button class="btn btn-default comprobar-smtp"><i class="fa fa-refresh"></i> Comprobar configuración</button>
										</div>
										<div align="center" style="display:none;" id="comprobar-smtp-loading">
											<img src="https://app.intranetzenter.com/build/img/loading.gif">
										</div>
									</div>
								</section>

							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab-5" aria-expanded="true">
								<section class="card">
									<header class="card-header card-header-lg">
										Accesos
									</header>
									<div class="card-block">
										<div class="col-md-12">
											<div class="checkbox-toggle">
												<input type="checkbox" id="check-toggle-1">
												<label for="check-toggle-1">Habilitar 2FA</label>
											</div>
											<div class="checkbox-toggle">
												<input type="checkbox" id="check-toggle-1">
												<label for="check-toggle-1">Habilitar Autorización Dispositivos</label>
											</div>
										</div>
									</div>
								</section>
							</div>

						</div>
					</section>
				</div>
			</div><!--.container-fluid-->
		</div><!--.page-content-->

		<?php require_once "../mainjs/js.php"; ?>
		<script src="../../public/js/lib/jquery-minicolors/jquery.minicolors.min.js"></script>
		<script type="text/javascript" src="generales.js"></script>

		<script>
			(function() {
				$(document).ready(function() {
					$('.demo').each(function() {
						$(this).minicolors({
							control: $(this).attr('data-control') || 'hue',
							defaultValue: $(this).attr('data-defaultValue') || '',
							format: $(this).attr('data-format') || 'hex',
							keywords: $(this).attr('data-keywords') || '',
							inline: $(this).attr('data-inline') === 'true',
							letterCase: $(this).attr('data-letterCase') || 'lowercase',
							opacity: $(this).attr('data-opacity'),
							position: $(this).attr('data-position') || 'bottom left',
							swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
							theme: 'bootstrap'
						});

					});
				});
			})();
		</script>

	</body>

	</html>

<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>