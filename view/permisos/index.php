<?php
require_once "../../config/conexion.php";
if (isset($_SESSION["usu_id"])) {

?>

    <!DOCTYPE html>
    <html>
    <?php require_once "../mainhead/head.php"; ?>

    <title>CRM :: Permisos </title>

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
                        <li class="active">Perfiles</li>
                    </ol>

                </div>
            </header>

            <div class="container-fluid">


                <div class="box-typical box-typical-padding" id="table">
                    <button type="button" id="btnnuevo" class="btn btn-inline btn-primary">Nuevo Perfil</button>

                    <section class="tabs-section">
                        <div class="tabs-section-nav tabs-section-nav-icons">
                            <div class="tbl">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tab-administrador-1" role="tab" data-toggle="tab" aria-expanded="false">
                                            <span class="nav-link-in" id="nombre-grupo-1">
                                                Administrador </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tab-dpto__marketing-25" role="tab" data-toggle="tab" aria-expanded="false">
                                            <span class="nav-link-in" id="nombre-grupo-25">
                                                Operativo </span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div><!--.tabs-section-nav-->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane fade" id="tab-administrador-1" aria-expanded="false">
                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Actualizar nombre
                                    </header>
                                    <div class="card-block">
                                        <input type="text" id="nombre-25" class="form-control" placeholder="Nombre del grupo" value="Dpto. Marketing" style="width:180px;float:left;margin-right:5px;">
                                        <button data-group-id="25" class="btn btn-success update-nombre"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </section>
                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Gestión Comercial
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="gestion_comercial" data-grupo="25" class="check-permisos" checked="" id="gestion_comercial">
                                                <label for="gestion_comercial">Modulo Habilitado</label>
                                            </div>
                                            <br>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="com_dashboard" data-grupo="25" class="check-permisos" id="com_dashboard">
                                                <label for="com_dashboard">Dashboard</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="com_crearcliente" data-grupo="25" class="check-permisos" id="com_crearcliente">
                                                <label for="com_crearcliente">Crear Cliente</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="com_buscarcliente" data-grupo="25" class="check-permisos" id="com_buscarcliente">
                                                <label for="com_buscarcliente">Buscar Clientes</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="com_detallecliente" data-grupo="25" class="check-permisos" id="com_detallecliente">
                                                <label for="com_detallecliente">Detalle Clientes</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;&emsp;&emsp;
                                                <input type="checkbox" value="com_masinformacion" data-grupo="25" class="check-permisos" id="com_masinformacion">
                                                <label for="com_masinformacion">Mas Informacion</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="com_masinfo_ver">
                                                <label for="com_masinfo_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="com_masinfo_edit">
                                                <label for="com_masinfo_edit">Editar</label>
                                            </div>

                                            <div class="checkbox-toggle">
                                                &emsp;&emsp;&emsp;
                                                <input type="checkbox" value="com_operaciones" data-grupo="25" class="check-permisos" id="com_operaciones">
                                                <label for="com_operaciones">Operaciones</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="com_ope_ver">
                                                <label for="com_ope_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="com_ope_crea">
                                                <label for="com_ope_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="com_ope_edit">
                                                <label for="com_ope_edit">Editar</label>
                                            </div>

                                            <div class="checkbox-toggle">
                                                &emsp;&emsp;&emsp;
                                                <input type="checkbox" value="com_comentarios" data-grupo="25" class="check-permisos" id="com_comentarios">
                                                <label for="com_comentarios">Comentarios</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="com_comen_ver">
                                                <label for="com_comen_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="com_comen_crea">
                                                <label for="com_comen_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="com_comen_edit">
                                                <label for="com_comen_edit">Editar</label>
                                                &emsp;
                                                <input type="checkbox" id="com_comen_priv">
                                                <label for="com_comen_priv">Privados</label>
                                            </div>

                                            <div class="checkbox-toggle">
                                                &emsp;&emsp;&emsp;
                                                <input type="checkbox" value="com_documentos" data-grupo="25" class="check-permisos" id="com_documentos">
                                                <label for="com_documentos">Documentos</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="com_doc_ver">
                                                <label for="com_doc_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="com_doc_crea">
                                                <label for="com_doc_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="com_doc_edit">
                                                <label for="com_doc_edit">Editar</label>
                                                &emsp;
                                                <input type="checkbox" id="com_doc_priv">
                                                <label for="com_doc_priv">Privados</label>
                                            </div>


                                        </div>
                                        <div class="col-md-6">


                                            Otras Opciones:
                                            <br><br>

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="com_fichacliente" data-grupo="25" class="check-permisos" id="com_fichacliente">
                                                <label for="com_fichacliente">&emsp;Descargar Ficha Cliente</label>
                                            </div>

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="com_crearpreselecta" data-grupo="25" class="check-permisos" id="com_crearpreselecta">
                                                <label for="com_crearpreselecta">&emsp;Crear Preselecta</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="com_cargarclientes" data-grupo="25" class="check-permisos" id="com_cargarclientes">
                                                <label for="com_cargarclientes">&emsp;Cargar Clientes</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;&emsp;&emsp;
                                                <input type="checkbox" value="com_carga_clientes" data-grupo="25" class="check-permisos" id="com_carga_clientes">
                                                <label for="com_carga_clientes">&emsp;&emsp;Subir Clientes</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;&emsp;&emsp;
                                                <input type="checkbox" value="com_carga_operaciones" data-grupo="25" class="check-permisos" id="com_carga_operaciones">
                                                <label for="com_carga_operaciones">&emsp;&emsp;Subir Operaciones</label>
                                            </div>

                                            <br>
                                            Privacidad:
                                            <br><br>

                                            <select id="com_ver" class="form-control">
                                                <option>Individual</option>
                                                <option>Grupo</option>
                                                <option>Todos</option>
                                            </select>

                                            <br>
                                            Permitir Gestión:
                                            <br><br>
                                            <select id="com_ges" class="form-control">
                                                <option>Sin Gestión</option>
                                                <option>Solo prospectos</option>
                                                <option>Prospectos y Completados</option>
                                                <option>Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                </section>

                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Contact Center
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="contact_center" data-grupo="25" class="check-permisos" checked="" id="contact_center">
                                                <label for="contact_center">Modulo Habilitado</label>
                                            </div>
                                            <br>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="cc_dashboard" data-grupo="25" class="check-permisos" id="cc_dashboard">
                                                <label for="cc_dashboard">Dashboard</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="cc_consola" data-grupo="25" class="check-permisos" id="cc_consola">
                                                <label for="cc_consola">Consola Llamada</label>
                                            </div>

                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="cc_campañas" data-grupo="25" class="check-permisos" id="cc_campañas">
                                                <label for="cc_campañas">Campañas</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="cc_cam_ver">
                                                <label for="cc_cam_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="cc_cam_crea">
                                                <label for="cc_cam_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="cc_cam_edit">
                                                <label for="cc_cam_edit">Editar</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            Privacidad:
                                            <br><br>

                                            <select id="cc_ver" class="form-control">
                                                <option>Individual</option>
                                                <option>Grupo</option>
                                                <option>Todos</option>
                                            </select>



                                        </div>
                                </section>

                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Intranet
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="intranet" data-grupo="25" class="check-permisos" checked="" id="intranet">
                                                <label for="intranet">Modulo Habilitado</label>
                                            </div>
                                            <br>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="int_docpersonal" data-grupo="25" class="check-permisos" id="int_docpersonal">
                                                <label for="int_docpersonal">Documentos Personales</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="int_docper_ver">
                                                <label for="int_docper_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="int_docper_crea">
                                                <label for="int_docper_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="int_docper_edit">
                                                <label for="int_docper_edit">Editar</label>
                                                &emsp;
                                                <input type="checkbox" id="int_docper_trash">
                                                <label for="int_docper_trash">PAPELERA</label>
                                            </div>

                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="int_docinternos" data-grupo="25" class="check-permisos" id="int_docinternos">
                                                <label for="int_docinternos">Documentos Internos</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="int_docint_ver">
                                                <label for="int_docint_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="int_docint_crea">
                                                <label for="int_docint_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="int_docint_edit">
                                                <label for="int_docint_edit">Editar</label>
                                                &emsp;
                                                <input type="checkbox" id="int_docint_trash">
                                                <label for="int_docint_trash">PAPELERA</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="int_comunicadosint" data-grupo="25" class="check-permisos" id="int_comunicadosint">
                                                <label for="int_comunicadosint">Comunicados Internos</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="int_comint_ver">
                                                <label for="int_comint_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="int_comint_crea">
                                                <label for="int_comint_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="int_comint_edit">
                                                <label for="int_comint_edit">Editar</label>
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            Ver Documentos Personales:
                                            <br><br>

                                            <select id="int_docper" class="form-control">
                                                <option>Individual</option>
                                                <option>Todos</option>
                                            </select>
                                            <br>
                                            Ver Documentos Internos:
                                            <br><br>

                                            <select id="int_docint" class="form-control">
                                                <option>Individual</option>
                                                <option>Todos</option>
                                            </select>
                                            <br>
                                            Ver Comunicados Internos:
                                            <br><br>

                                            <select id="int_comint" class="form-control">
                                                <option>Individual</option>
                                                <option>Todos</option>
                                            </select>
                                        </div>
                                </section>

                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Tareas
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="tareas" data-grupo="25" class="check-permisos" checked="" id="tareas">
                                                <label for="tareas">Modulo Habilitado</label>
                                            </div>
                                            <br>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="tar_listado" data-grupo="25" class="check-permisos" id="tar_listado">
                                                <label for="tar_listado">Listado Tareas</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="tar_lis_ver">
                                                <label for="tar_lis_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="tar_lis_crea">
                                                <label for="tar_lis_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="tar_lis_edit">
                                                <label for="tar_lis_edit">Editar</label>
                                                &emsp;
                                                <input type="checkbox" id="tar_lis_asig">
                                                <label for="tar_lis_asig">Asignar</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="tar_categorias" data-grupo="25" class="check-permisos" id="tar_categorias">
                                                <label for="tar_categorias">Categorias</label>
                                            </div>
                                        </div>
                                </section>

                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Informes
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="informes" data-grupo="25" class="check-permisos" checked="" id="informes">
                                                <label for="informes">Modulo Habilitado</label>
                                            </div>
                                            <br>
                                            <div class="checkbox">
                                                &emsp;
                                                <input type="checkbox" id="info_1">
                                                <label for="info_1">Informe 1</label>
                                                &emsp;
                                                <input type="checkbox" id="info_2">
                                                <label for="info_2">Informe 2</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;
                                                <input type="checkbox" id="info_3">
                                                <label for="info_3">Informe 3</label>
                                                &emsp;
                                                <input type="checkbox" id="info_4">
                                                <label for="info_4">Informe 4</label>
                                            </div>

                                        </div>
                                </section>

                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Configuraciones
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="configuraciones" data-grupo="25" class="check-permisos" checked="" id="configuraciones">
                                                <label for="configuraciones">Modulo Habilitado</label>
                                            </div>
                                            <br>

                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_generales" data-grupo="25" class="check-permisos" id="conf_generales">
                                                <label for="conf_generales">Generales</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_usuarios" data-grupo="25" class="check-permisos" id="conf_usuarios">
                                                <label for="conf_usuarios">Usuarios</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="conf_user_ver">
                                                <label for="conf_user_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_user_crea">
                                                <label for="conf_user_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_user_edit">
                                                <label for="conf_user_edit">Editar</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_perfiles" data-grupo="25" class="check-permisos" id="conf_perfiles">
                                                <label for="conf_perfiles">Perfiles</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="conf_per_ver">
                                                <label for="conf_per_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_per_crea">
                                                <label for="conf_per_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_per_edit">
                                                <label for="conf_per_edit">Editar</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_entidades" data-grupo="25" class="check-permisos" id="conf_entidades">
                                                <label for="conf_entidades">Entidades</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="conf_ent_ver">
                                                <label for="conf_ent_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_ent_crea">
                                                <label for="conf_ent_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_ent_edit">
                                                <label for="conf_ent_edit">Editar</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_listciudades" data-grupo="25" class="check-permisos" id="conf_listciudades">
                                                <label for="conf_listciudades">Listado Ciudades</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="conf_lciu_ver">
                                                <label for="conf_lciu_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_lciu_crea">
                                                <label for="conf_lciu_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_lciu_edit">
                                                <label for="conf_lciu_edit">Editar</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_grupocom" data-grupo="25" class="check-permisos" id="conf_grupocom">
                                                <label for="conf_grupocom">Grupos Comerciales</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="conf_gcom_ver">
                                                <label for="conf_gcom_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_gcom_crea">
                                                <label for="conf_gcom_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_gcom_edit">
                                                <label for="conf_gcom_edit">Editar</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="conf_grupocc" data-grupo="25" class="check-permisos" id="conf_grupocc">
                                                <label for="conf_grupocc">Grupos de Llamada</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="conf_gcc_ver">
                                                <label for="conf_gcc_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_gcc_crea">
                                                <label for="conf_gcc_crea">Crear</label>
                                                &emsp;
                                                <input type="checkbox" id="conf_gcc_edit">
                                                <label for="conf_gcc_edit">Editar</label>
                                            </div>

                                        </div>
                                </section>

                                <section class="card">
                                    <header class="card-header card-header-lg">
                                        <i class="fa fa-gear"></i> Seguridad
                                    </header>
                                    <div class="card-block">
                                        <div class="col-md-6">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" value="seguridad" data-grupo="25" class="check-permisos" checked="" id="seguridad">
                                                <label for="seguridad">Modulo Habilitado</label>
                                            </div>
                                            <br>

                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="seg_configuracion" data-grupo="25" class="check-permisos" id="seg_configuracion">
                                                <label for="seg_configuracion">Configuración</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="seg_registros" data-grupo="25" class="check-permisos" id="seg_registros">
                                                <label for="seg_registros">Registros del Sistema</label>
                                            </div>
                                            <div class="checkbox-toggle">
                                                &emsp;
                                                <input type="checkbox" value="seg_dispositivo" data-grupo="25" class="check-permisos" id="seg_dispositivo">
                                                <label for="seg_dispositivo">Dispositivos</label>
                                            </div>
                                            <div class="checkbox">
                                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <input type="checkbox" id="seg_dis_ver">
                                                <label for="seg_dis_ver">Ver</label>
                                                &emsp;
                                                <input type="checkbox" id="seg_dis_aut">
                                                <label for="seg_dis_aut">Autorizar</label>
                                                &emsp;
                                                <input type="checkbox" id="seg_dis_eli">
                                                <label for="seg_dis_eli">Eliminar</label>
                                            </div>
                                        </div>
                                </section>


                                <div class="alert alert-warning alert-no-border" role="alert">
                                    <strong>Eliminar grupo:</strong> Este grupo no puede ser eliminado porque hay 1 usuario que lo estan utilizando. Antes de eliminar el grupo modifica a los usuarios afectados.
                                </div>
                            </div>
                        </div><!--.tab-content-->
                    </section>



                </div>
            </div><!--.container-fluid-->
        </div><!--.page-content-->
        >
        <?php require_once "../mainjs/js.php"; ?>
        <script type="text/javascript" src="permisos.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>