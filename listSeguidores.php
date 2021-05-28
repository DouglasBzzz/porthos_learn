<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 14/09/2017
 * Time: 13:40
 */
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: index.php?erro=1');
    }
    require_once('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn&trade; | Seguidores</title>
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-users"></i>  Seguidores
            </h1>
        </section>

        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
<!--                    <h2 class="box-title">Docentes que seguem você:</h2>-->
                </div>
                <div class="box-body">
                    <?php
                        //$idDocente = $_GET['idDocente'];
                        $idDocente = new functions();
                        $idDocente ->retListaSeguidores($_GET['idDocente']);
                    ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <form action="profile.php" class="form-group ">
                        <button type="submit" class="pull-right btn btn-primary"><i class="fa fa-home"></i> Home</button>
                    </form>
                </div>
                <!-- /.box-footer-->
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
</body>
</html>
