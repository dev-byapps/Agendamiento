    <header class="site-header">
        <div class="container-fluid" style="padding-left: 0px;">

            <a href="../home/" class="site-logo">
                <img class="hidden-md-down" src="../../public/img/logo-2.png" alt="">
                <img class="hidden-lg-up" src="../../public/img/logo-2-mob.png" alt="">
            </a>

            <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
                <span>toggle menu</span>
            </button>

            <button class="hamburger hamburger--htla" id="menu">
                <span>toggle menu</span>
            </button>

            <div class="site-header-content">
                <div class="site-header-content-in">
                    <div class="site-header-shown">

                        <!-- <div class="dropdown dropdown-notification notif">
                            <a href="#" class="header-alarm dropdown-toggle active" id="dd-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="font-icon-alarm"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
                                <div class="dropdown-menu-notif-header">
                                    Notificaciones
                                    <span class="label label-pill label-danger">1</span>
                                </div>
                                <div class="dropdown-menu-notif-list">
                                    <div class="dropdown-menu-notif-item">
                                        <div class="photo">
                                            <img src="../../public/img/photo-64-1.jpg" alt="">
                                        </div>
                                        <div class="dot"></div>
                                        <a href="#">Usuario</a> tienes tareas vencidas
                                        <div class="color-blue-grey-lighter">7 hours ago</div>
                                    </div>
                                </div>
                                <div class="dropdown-menu-notif-more">
                                    <a href="#">Ver mas</a>
                                </div>
                            </div>
                        </div> -->

                        <div class="dropdown user-menu">
                            <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="../../public/img/avatar-2-64.png" alt="">
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">

                                <a class="dropdown-item" href="../perfil/"><span class="font-icon glyphicon glyphicon-user"></span>Mi Cuenta</a>
                                <?php if (false): // OCULTAR SOPORTE
                                ?>
                                    <a class="dropdown-item" href="../mntsoporte/">
                                        <span class="font-icon glyphicon glyphicon-question-sign">
                                        </span>Soporte
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
                            </div>
                        </div>
                    </div><!--.site-header-shown-->
                    <div class="mobile-menu-right-overlay"></div>

                </div><!--site-header-content-in-->
            </div><!--.site-header-content-->
        </div><!--.container-fluid-->
    </header><!--.site-header-->

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var timeout;
            var maxInactiveTime = 10 * 60 * 1000;

            function resetTimer() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    alert("La sesión ha expirado debido a inactividad.");
                    location.href = "../logout/logout.php"; // Redirige a la página de cierre de sesión
                }, maxInactiveTime);
            }

            // Reinicia el temporizador en cada evento de usuario relevante
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;

            // Inicia el temporizador cuando se carga la página
            resetTimer();
        });
    </script>