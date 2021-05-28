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
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn&trade; | Buscar</title>
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

    <!--	BARRA LATERAL - MENU    -->
	
        <?php include 'sidebar.php';?>
	
    <!--  / BARRA LATERAL - MENU   -->



    <!-- CONTEUDO PAGINA -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
               <i class="fa fa-search"></i> Buscar
            </h1>
        </section>

        <!--  / CONTEUDO PAGINA -->


        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <legend> Busque por Conteúdos, Docentes ou Interesses...</legend>
                </div>

                <form class="form-group-buscar" name="formProcuraDocente" method="get" id="form_procurar_docente">
                    <div class="input-group">
                       <input type="text" id="nome_docente" name="nome_docente" class="form-control" placeholder="Mínimo de 3 caracteres..."/>
                        <span class="input-group-btn">
                            <button class="btn btn-primary" id="btn_procurar_docente" type="button"><i class="fa fa-search"></i> Buscar</button>
                         </span>
                    </div>
                </form>

                <div class="box-body col-md-6" id="docentes">
                <!-- listagem de docentes -->
                </div>

                <div class="box-body col-md-6" id="aulas">
                    <!--listagem de aulas-->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <form action="profile.php" class="form-group">
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


    <!-- RODAPE -->
    
        <?php include 'footer.php';?>

    <!-- / RODAPE -->
	
	
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
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

<script type="text/javascript">
	$(document).ready( function(){
		//associar o evento de click ao botão
		$('#btn_procurar_docente').click( function(){
			if($('#nome_docente').val().length > 2){

                $.ajax({
                    url: 'get_aulas_busca.php',
                    method: 'post',
                    data: $('#form_procurar_docente').serialize(),
                    success: function(data) {
                        $('#aulas').html(data);
                    },
                    error: function (data) {
                        $('#aulas').html(data);
                    }
                });

				$.ajax({
					url: 'get_docentes.php',
					method: 'post',
					data: $('#form_procurar_docente').serialize(),
					success: function(data) {

						$('#docentes').html(data);

						$('.btn_seguir').click(function () {
                            var vIdSeguido = $(this).data('iddocenteseguido');

                            $('#btn_seguir_'+vIdSeguido).hide();
                            $('#btn_deixarseguir_'+vIdSeguido).show();

                            /*
                            $('#btn_seguir'+vIdSeguido).show();
                            $('#btn_deixarseguir'+vIdSeguido).show(); */ //vFuncional de exibição dos dois botões. < by Douglas

                            $.ajax({
                               url: 'seguir.php',
                               method: 'post',
                               data: {idSeguido : vIdSeguido},
                               /*success: function (data) {
                                   alert('Você agora está seguindo esse usuário!');
                               }*/
                            });
                        });

						$('.btn_deixar_seguir').click(function () {
                            var vIdSeguido = $(this).data('iddocenteseguido');

                            $('#btn_seguir_'+vIdSeguido).show();
                            $('#btn_deixarseguir_'+vIdSeguido).hide();

                            /*$('#btn_seguir'+vIdSeguido).show();
                            $('#btn_deixarseguir'+vIdSeguido).show();*/ //comentado by Douglas

                            $.ajax({
                                url: 'deixarSeguir.php',
                                method: 'post',
                                data: {idSeguidoNao : vIdSeguido},
                                /*success: function (data) {
                                    alert('Você não está mais seguindo esse usuário!');
                                }*/
                            });

                        })
					}
				});
			}
		});
	});
</script>

<script type="text/javascript">
    $(function(){
        $('input, textarea').on('keypress', function(e){
            if (e.keyCode == 13) {
                e.preventDefault();
                $("#btn_procurar_docente").click();
            }
        });
    });
</script>

</body>
</html>
