<?php
// header('Content-Type: text/html; charset=utf-8');
$usu_perfil = $_SESSION["usu_perfil"];
?>


<style>
    .side-menu {



        background: #5B80A3;

    }

    .side-menu-list li.opened {
        background-color: #F2F5FA;

    }

    .side-menu-list a:hover,
    .side-menu-list li>span:hover {
        background-color: #D6E4F0;
        color: #2A4A66
    }

    .side-menu-list a:hover .lbl,
    .side-menu-list li>span:hover .lbl {
        color: #3A607E;

    }

    .side-menu-list a:hover .material-symbols-rounded {
        color: #3A607E;
    }

    .side-menu-list .lbl {
        font-weight: 400;
        color: #F5F7FA;
        font-size: 1rem;
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    .side-menu-list .lblsb {
        font-weight: 500;
        color: #3A607E;
        font-size: 1rem;
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }

    a {
        color: #F5F7FA;
        text-decoration: none;
        cursor: pointer;
        outline: 0 !important;
    }

    .ablack {
        color: #919fa9;
        font-size: 14px;
    }

    .material-symbols-rounded {
        position: absolute;
        left: 18px;
        font-size: 1.4rem;
        color: #F5F7FA;
    }

    .side-menu-list material-symbols-rounded:hover .lbl,
    .side-menu-list li>span:hover .lbl,
    .side-menu-list li>span:hover .material-symbols-rounded {
        color: #3A607E;

    }

    .side-menu-list li.opened>span .material-symbols-rounded {

        color: #3A607E
    }

    .side-menu-list li.opened>span .lbl {

        color: #3A607E
    }
</style>


<nav class="side-menu">
    <ul class="side-menu-list">

        <li class="">
            <a href="../home/">
                <span class="material-symbols-rounded">home</span>
                <span class="lbl">Inicio</span>
            </a>
        </li>

        <?php if ($usu_perfil == "Administrador") { ?>
            <li class="blue with-sub">
                <span>
                    <span class="material-symbols-rounded"> forum </span>
                    <span class="lbl">Contact Center</span>
                </span>
                <ul>
                    <li><a href="../dashccenter/"><span class="lblsb"> Dashboard</span></a></li>
                    <li><a href="../listarcampanas/"><span class="lblsb"> Consola de Agente</span></a></li>
                    <li><a href="../campanas/"><span class="lblsb"> Gestión de Campañas</span></a></li>
                </ul>
            </li>

            <li class="blue with-sub">
                <span>
                    <span class="material-symbols-rounded">
                        calendar_month
                    </span>
                    <span class="lbl">Planificador</span>
                </span>
                <ul>
                    <li><a href="../calendario/"><span class="lblsb">Calendario</span></a></li>
                    <li><a href="../tareas/"><span class="lblsb">Gestor de Tareas</span></a></li>
                    <li><a href="../agendas/"><span class="lblsb">Gestor de Agenda</span></a></li>
                    <li><a href="../tarcategorias/"><span class="lblsb">Categorias</span></a></li>
                    <li><a href="../cargartareas/"><span class="lblsb">Cargar Tareas</span></a></li>
                </ul>
            </li>

            <li class="blue with-sub">
                    <span>
                        <span class="material-symbols-rounded">
                            manufacturing
                        </span>
                        <span class="lbl">Configuraciones</span>
                    </span>
                    <ul>
                        <?php

                        ?>
                        <li><a href="../generales/"><span class="lblsb"> Generales</span></a></li>
                        <li><a href="../usuarios/"><span class="lblsb"> Usuarios</span></a></li>
                        <li><a href="../permisos/"><span class="lblsb"> Perfiles</span></a></li>
                        <li><a href="../entidades/"><span class="lblsb"> Entidades</span></a></li>
                        <li><a href="../ciudades/"><span class="lblsb"> Listado Ciudades</span></a></li>
                        <li><a href="../grupocomercial/"><span class="lblsb"> Grupos Comerciales</span></a></li>
                        <li><a href="../grupoccenter/"><span class="lblsb"> Grupos de Llamadas</span></a></li>
                    </ul>
                </li>





        <?php } else {?>

            <?php if ($usu_perfil != "Agente") { ?>
                <li class="blue with-sub">
                    <span>
                        <span class="material-symbols-rounded">
                            group
                        </span>
                        <span class="lbl">Gestión Comercial</span>
                    </span>
                    <ul>
                        <li><a href="../dashcomercial/" id="dashboardLink"><span class="lblsb"> Dashboard</span></a></li>
                        <li><a href="../buscarclientes/"><span class="lblsb"> Buscar Cliente</span></a></li>
                        <li><a href="../crearcliente/?s=cc"><span class="lblsb" id="btn_crear">Crear Cliente</span></a></li>
                        <li><a href="../crearcliente/?s=cp"><span class="lblsb" id="btn_crear">Crear Consulta</span></a></li>
                        <li><a href="../cargarclientes/"><span class="lblsb"> Cargar Clientes</span></a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($usu_perfil != "Asesor" && $usu_perfil != "Operativo") { ?>
                <li class="blue with-sub">
                    <span>
                        <span class="material-symbols-rounded">
                            forum
                        </span>
                        <span class="lbl">Contact Center</span>
                    </span>
                    <ul>
                        <li><a href="../dashccenter/"><span class="lblsb"> Dashboard</span></a></li>
                        <?php if ($usu_perfil != "RRHH") { ?>
                            <li><a href="../listarcampanas/"><span class="lblsb"> Consola de Agente</span></a></li>
                        <?php }
                        if ($usu_perfil != "Agente" && $usu_perfil != "Asesor/Agente" && $usu_perfil != "RRHH" && $usu_perfil != "Coordinador") { ?>
                            <li><a href="../campanas/"><span class="lblsb"> Gestión de Campañas</span></a></li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>

            <li class="blue with-sub">
                <span>
                    <span class="material-symbols-rounded">
                        travel_explore
                    </span>
                    <span class="lbl">Intranet</span>
                </span>
                <ul>
                    <li><a href="../docpersonales/"><span class="lblsb">Documentos Personales</span></a></li>
                    <li><a href="../docinternos/"><span class="lblsb">Documentos Internos</span></a></li>
                    <li><a href="../comunicados/"><span class="lblsb">Comunicados Internos</span></a></li>
                </ul>
            </li>

            <li class="blue with-sub">
                <span>
                    <span class="material-symbols-rounded">
                        calendar_month
                    </span>
                    <span class="lbl">Planificador</span>
                </span>
                <ul>
                    <li><a href="../calendario/"><span class="lblsb">Calendario</span></a></li>
                    <li><a href="../tareas/"><span class="lblsb">Gestor de Tareas</span></a></li>
                    <li><a href="../agendas/"><span class="lblsb">Gestor de Agenda</span></a></li>
                    <li><a href="../tarcategorias/"><span class="lblsb">Categorias</span></a></li>
                    <li><a href="../cargartareas/"><span class="lblsb">Cargar Tareas</span></a></li>
                </ul>
            </li>

            <?php if ($usu_perfil == "Operativo" || $usu_perfil == "Gerencia" || $usu_perfil == "Administrador") { ?>

                <li class="blue with-sub">
                    <span>
                        <span class="material-symbols-rounded">
                            bar_chart_4_bars
                        </span>
                        <span class="lbl">Informes</span>
                    </span>
                    <ul>
                        <li><a href="../informes/"><span class="lblsb"> Informes Comerciales</span></a></li>
                        <?php if ($usu_perfil != "Operativo") { ?>

                            <li><a href="../infocc/"><span class="lblsb"> Informes Contact Center</span></a></li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>

            <?php if ($usu_perfil == "Administrador") { ?>
                <li class="blue with-sub">
                    <span>
                        <span class="material-symbols-rounded">
                            manufacturing
                        </span>
                        <span class="lbl">Configuraciones</span>
                    </span>
                    <ul>
                        <?php

                        ?>
                        <li><a href="../generales/"><span class="lblsb"> Generales</span></a></li>
                        <li><a href="../usuarios/"><span class="lblsb"> Usuarios</span></a></li>
                        <li><a href="../permisos/"><span class="lblsb"> Perfiles</span></a></li>
                        <li><a href="../entidades/"><span class="lblsb"> Entidades</span></a></li>
                        <li><a href="../ciudades/"><span class="lblsb"> Listado Ciudades</span></a></li>
                        <li><a href="../grupocomercial/"><span class="lblsb"> Grupos Comerciales</span></a></li>
                        <li><a href="../grupoccenter/"><span class="lblsb"> Grupos de Llamadas</span></a></li>
                    </ul>
                </li>

            <?php } ?>

            <li class="blue with-sub">
                <span>
                    <span class="material-symbols-rounded">
                        admin_panel_settings
                    </span>
                    <span class="lbl">Seguridad</span>
                </span>
                <ul>
                    <li><a href="../dispositivos/"><span class="lblsb"> Dispositivos</span></a></li>
                    <li><a href="../tokens/"><span class="lblsb"> Tokens API</span></a></li>
                    <li><a href="../registros/"><span class="lblsb"> Registros</span></a></li>
                </ul>
            </li>

        <?php } ?>       

    </ul>
</nav>