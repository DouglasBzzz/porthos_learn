    <!-- BARRA LATERAL PADRÃO DE TODAS AS PÁGINAS. -->
<!-- DEVE SER ADICIONADA VIA INCLUDE. -->


<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <?php
                echo'<div class="pull-left image">
                    <div class="profile-user-min img-responsive img-circle pull-left"
                        style="background: url('.retFoto($_SESSION['id']).') center">
                    </div>
                </div>';
                ?>
                <div class="pull-left info">
                    <p>
                        <?php
                        $nomeDocente = new functions();
                        $nomeDocente -> retNomeDocente($_SESSION['id']);
                        ?>
                    </p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">Menu</li>

<!--                <li class="treeview">-->
<!--                    <a href="profile.php">-->
<!--                        <i class="fa fa-user-circle"></i>-->
<!--                        <span>Perfil</span>-->
<!--                        <span class="pull-right-container">-->
<!--              <i class="fa fa-angle-left pull-right"></i>-->
<!--            </span>-->
<!--                    </a>-->
<!--                    <ul class="treeview-menu">-->
<!--                        <li><a href="profile.php"><i class="fa fa-circle-o"></i> Sua Atividade</a></li>-->
<!--                        <li><a href="profile.php"><i class="fa fa-circle-o"></i> Feed</a></li>-->
<!---->
<!--                        <li><a href="profile.php"><i class="fa fa-circle-o"></i> Configurações</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
                <li><a href="profile.php"><i class="fa fa-home"></i> <span>Home</span></a> </li>

                <li><a href="aula.php"><i class="fa fa-book"></i> <span>Nova Aula</span></a> </li>

				<li><a href="buscar.php"><i class="fa fa-search"></i> <span>Buscar</span></a> </li>

                <?php
                echo'<li><a href="listSeguidos.php?idDocente='.$_SESSION['id'].'"><i class="fa fa-user-circle"></i> <span>Seguindo</span></a></li>
                <li><a href="listSeguidores.php?idDocente='.$_SESSION['id'].'"><i class="fa fa-users"></i> <span>Seguidores</span></a></li>';
                ?>

                <!--<li><a href="profile.php"><i class="fa fa-star"></i> <span>Interesses</span></a></li>-->

                <li><a href="contato.php"><i class="fa fa-envelope"></i> <span>Contato - Porthos</span></a></li>

            </ul>
        </section>
        <!-- /.sidebar -->
</aside>