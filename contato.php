<?php
session_start();
if(!isset($_SESSION['login'])){
    header('Location: profile.php');
}
require_once ('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn&trade; | Contato</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/86f1dc7ee7.js"></script>
    <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/css/blue.css">
    <!-- favicon	-->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/css/all-skins.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="assets/css/bootstrap3-wysihtml5.min.css">

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">


    <!--	BARRA SUPERIOR - CABEÇALHO	-->

        <?php include 'header.php';?>

    <!--  / BARRA SUPERIOR - CABEÇALHO	-->

    <!--	BARRA LATERAL - MENU -->
	
        <?php include 'sidebar.php';?>
	
    <!--  / BARRA LATERAL - MENU -->


    <!-- CONTEUDO PAGINA -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <h1>
                <i class="fa fa-envelope"></i>  Contato - Porthos
            </h1>
        </section>

        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Entre em contato com a Porthos</h3>

                </div>
                <form name="frmContato" id="idFrmContato" method="POST" action="registraContato.php" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="box-body">
                            <div class="form-group">
                                <input class="form-control" placeholder="Assunto:" name="title" id="idTitle" required>
                            </div>
                            <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" name="txtComentario" style="height: 300px">
                      <h1>Encontrou algum problema no Learn?</h1>
                      <h2>Ou tem alguma sugestão?</h2>
                      <p>Nos envie sua sugestão ou reclamação por aqui, trataremos sua solicitação com carinho e lhe retornaremos o mais rápido possível.</p>
                      <br/>
                      <p>Obrigado,</p>
                      <p>Equipe Porthos</p>
                    </textarea>
                            </div>

                            <!--<div class="form-group">
                                <label class="control-label">Encaminhe documentos...:</label>
                                <!--<span class="hidden-xs"> Buscar... </span>
                                <input id="arquivos" name="anexos[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true" >
                                <!--<input type="submit" value="Enviar arquivo" />
                                <br/>
                                <br/>
                                <!--<form enctype="multipart/form-data" action="upload.php" method="POST"></form>
                            </div>-->
                        </div>

                        <div class="box-footer">
                            <button type="submit" class=" pull-right btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
                        </div>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--  / CONTEUDO PAGINA -->

    <!-- RODAPE -->
    
        <?php include 'footer.php';?>

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
<!-- Page Script -->
<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
</script>

</body>
</html>
