<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 30/12/2017
 * Time: 13:29
 */

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

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/css/bootstrap3-wysihtml5.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <!--<link rel="stylesheet" href="assets/css/all-skins.css">-->

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <div class="col-xs-2">
                <input type="button" class="btn btn-primary" value="Atualizar" onClick='parent.location="javascript:location.reload()"'/>
                <h3><label><a href="indicesAdm.php">Home</a></label></h3>
            </div>

            <!-- Default box -->




                <div class="col-xs-6">

                    <div class="box">
                        <div class="box-header with-border">
                            <h2 class="box-title">E-mail Marketing</h2>
                            <hr>
                        </div>
                        <div class="box-body">
                            <div class="box-footer">

                                <form id="formDisparoEmailMKT" action="disparaEmailMKT.php" method="post">

                                    <div class="form-group col-md-8">

                                        <div class="form-group">
                                            <input type="text" id="txtAssunto" name="txtAssunto" class="form-control" placeholder="Assunto do E-mail"/>
                                        </div>

                                        <div class="form-group">

                                            <textarea id="conteudo" class="form-control" name="txtConteudo" style="height: 300px">

                                            </textarea>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label>Filtro da consulta: </label>
                                            <textarea id="filtro" class="form-control" name="txtFiltro" style="font-family: 'Courier New', Monospace;height: 140px">
select d.nome, d.email
from docente as d
where d.situacao = 1 and d.recebenotificacao = 1 and email <>'' and

                                            </textarea>
                                        </div>
                                        <hr>
                                        <button type="submit" value="enviar" class="pull-right btn btn-primary">Enviar</button>
                                        <br/>
                                        <br/>
                                        <p>
                                            <label>**Importante** o filtro default para disparo é o da textArea. <br/>
                                                COMPLEMENTEM ele para direcionar para alguém especifico, ou o que desejarem<br/>
                                                MAS LEMBREM DE LIMPA-LO CASO O OBJETIVO SEJA DISPARAR PARA TODOS OS DOCENTES!!!
                                            </label>
                                        <hr>
                                        <label>**Importante 2** lembrem de verificar ortografia antes de mandar, porque do jeito que estiver
                                            escrito no assunto, e na textArea, é do jeito que vai chegar pro usuário.</label>
                                        </p>

                                    </div>

                                </form>

                            </div>
                            <!-- /.box-footer-->
                        </div>
                    </div>
                </div>


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
<script src="assets/js/jquery-2.2.3.min.js"></script>
<!-- SlimScroll -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/js/bootstrap.js"></script>
<!-- FastClick -->
<script src="assets/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/app.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/js/demo.js"></script>
<!-- Slimscroll -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="assets/js/bootstrap3-wysihtml5.all.min.js"></script>

<script>
    $(function () {
        //Add text editor
        $("#conteudo").wysihtml5();
    });
</script>

</body>
</html>