<!-- HEADER PADRÃO DE TODAS AS PÁGINAS. -->
<!-- DEVE SER ADICIONADA VIA INCLUDE. -->


<header class="main-header">
    <!-- Logo -->
    <a href="profile.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="assets/imgs/glyph-porthos-branco.png"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="assets/imgs/glyph-porthos-branco.png"><img
                src="assets/imgs/learn-semlogo25.png"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li>
                    <a href="profile.php"><i class="fa fa-home"></i></a>
                </li>
				
				<li>
                    <!--          Botão de buscar              -->
                    <a href="buscar.php"><i class="fa fa-search"></i></a>
                </li>

                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <!--              <span class="label label-warning">10</span>-->
                        <?php
                            $nNotificacoes = new functions();
                            $nNotificacoes->retNNotificacoes($_SESSION['id']);
                            //echo '<span class="label label-warning">'$nNotificacoes'</span>';
                        //echo "<span class='label label-warning'>$nNotificacoes</span>";
                        ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Novas notificações:</li>
                        <li>
                            <ul class="menu">
                                <?php
                                $notificacoes = new functions();
                                $notificacoes ->retNotificoes($_SESSION['id']);
                                ?>
                            </ul>
                        </li>
<!--                        <li class="footer"><a href="#">Ver Tudo</a></li>-->
                    </ul>
                </li>

                <li>
                    <!--          Botão Sign-out Sair              -->
                    <a href="sair.php"><i class="fa fa-sign-out"></i></a>
                </li>
				
            </ul>
        </div>
    </nav>
</header>
