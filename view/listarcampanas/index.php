<?php
require_once "../../config/conexion.php";
$usu_id = isset($_SESSION["usu_id"]) ? $_SESSION["usu_id"] : '';
$usu_perfil = isset($_SESSION["usu_perfil"]) ? $_SESSION["usu_perfil"] : '';
if (isset($_SESSION["usu_id"])) {
?>
	<!DOCTYPE html>
	<html>
	<?php require_once "../mainhead/head.php"; ?>
	<script>
		var usu_id = '<?php echo $usu_id; ?>';
		var usuPerfil = '<?php echo $usu_perfil; ?>';
	</script>
	<title>CRM :: Campañas </title>
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
						<li class="active">Listado de Campañas</li>
					</ol>
				</div>
			</header>

			<div class="container-fluid" id="container">
				<div class="row card-user-grid"></div>
			</div>

		</div>
		<?php require_once "../mainjs/js.php"; ?>
		<script type="text/javascript" src="listarcampanas.js"></script>
	</body>

	</html>
<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>