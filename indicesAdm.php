<?php
session_start();
require_once('funcoesAdm.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>|Administrator|</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/86f1dc7ee7.js"></script>
    <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../porthoslearn/assets/css/bootstrap.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../porthoslearn/assets/css/blue.css">
    <!-- favicon	-->
    <link rel="shortcut icon" href="../porthoslearn/assets/css/favicon.ico"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <!--<link rel="stylesheet" href="assets/css/all-skins.css">-->

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">


    <!--	BARRA SUPERIOR - CABEÇALHO	-->



    <!--  / BARRA SUPERIOR - CABEÇALHO	-->

    <!--	BARRA LATERAL - MENU -->



    <!--  / BARRA LATERAL - MENU -->


    <!-- CONTEUDO PAGINA -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <!-- Default box -->


            <form class="form-group">

                <div class="col-xs-10">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Dados informativos</h3>

                        </div>
                        <div class="box-body">

                            <?php

                            if ($_SESSION['id'] == 107 || $_SESSION['id'] == 108 || $_SESSION['id'] == 109){
                                $stats = new funcoesAdm();
                                $stats ->retStats();
                            }else{
                                echo 'VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSE RECURSO!!';
                            }

                            ?>

                        <!-- /.box-body -->
                        <div class="box-footer">

                        </div>
                        <!-- /.box-footer-->
                    </div>

                </div>

            </div>

                <div class="col-lg-1 col-xs-2">
                    <input type="button" class="btn btn-primary" value="Atualizar" onClick='parent.location="javascript:location.reload()"'/>
                </div>
                <?php
                if ($_SESSION['id'] == 107 || $_SESSION['id'] == 108 || $_SESSION['id'] == 109){
                    echo '<a href="contatosAdm.php" class="btn btn-default"/>Contatos</a>';
                    echo '<a href="emailMKT.php" class="btn btn-default"/>E-mail MKT </a>';
                    /*echo '<a href="atualizaConfiguracoes.php" class="btn btn-default"/>Atualiza Configurações</a>';*/
                }
                ?>


            <!-- /.box -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--  / CONTEUDO PAGINA -->

    <!-- RODAPE -->


    <!-- / RODAPE -->

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../porthoslearn/assets/js/jquery-2.2.3.min.js"></script>
<!-- SlimScroll -->
<script src="../porthoslearn/assets/js/jquery.slimscroll.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../porthoslearn/assets/js/bootstrap.js"></script>
<!-- FastClick -->
<script src="../porthoslearn/assets/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../porthoslearn/assets/js/app.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../porthoslearn/assets/js/demo.js"></script>
<!-- Slimscroll -->
<script src="../porthoslearn/assets/js/jquery.slimscroll.js"></script>
</body>
</html>
