<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: profile.php');
}
require_once('db.class.php');
require_once('functions.php');
include ('nFuncoes.php');
require_once ('Docente.php');

//$docente = new functions();
$docente = new functions();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Learn&trade; | Perfil</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/86f1dc7ee7.js"></script>
    <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- bootstrap datepicker -->
  	<link rel="stylesheet" href="assets/css/datepicker3.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="assets/css/select2.min.css">
	<!-- Theme style -->
    <link rel="stylesheet" href="assets/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/css/blue.css">
    <!-- FileInput -->
    <link href="assets/css/cssFileInput/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- favicon	-->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/css/all-skins.css">

    <!--função para execução do loading antes da pagina-->
    <script type="text/javascript">
        function id(el) {
            return document.getElementById(el);
        }
        function hide(el) {
            id(el).style.display = 'none';//escondendo tudo
        }
        window.onload = function() {
            id('all').style.display = 'block';//liberando qndo terminar
            hide('loading');
        }
    </script>
</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini fixed">
<div class="wrapper">

     <!--	BARRA SUPERIOR - CABEÇALHO	-->

        <?php include 'header.php';?>

    <!--  / BARRA SUPERIOR - CABEÇALHO	-->

    <!--	BARRA LATERAL - MENU -->

        <?php include 'sidebar.php';?>

    <!--  / BARRA LATERAL - MENU -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<!-- Main content -->
		<section class="content" id="all">
			<div class="row">
				<div class="col-md-3">
					<div class="box box-widget widget-user">
                        <?php echo '<div class="widget-user-header bg-black"
                                style="background: url('.retCapa($_SESSION['id']).') center">';
                             ?>
                            <h3 class="widget-user-username">
                                <?php
                                /*$nomeDocente = new functions();
                                $nomeDocente -> retNomeDocente($_SESSION['id']);*/
                                //$docente ->retNomeDocente($_SESSION['id']);
                                $docente -> retNomeDocente($_SESSION['id']);
                                ?>
                            </h3>
                        </div>
                        <div class="widget-user-image">
                            <?php
                            echo '<div class="profile-user-img img-responsive img-circle"
                                style="background: url('.retFoto($_SESSION['id']).') center">
                                </div>';
                            ?>
                        </div>
						<div class="box-body-list box-profile">
						  <ul class="list-group list-group-unbordered">
							<li class="list-group-item">
							  <b>Seguindo</b> <a class="pull-right">
								<?php
                                    echo '<a class="pull-right" href="listSeguidos.php?idDocente='.$_SESSION['id'].'">';
									/*$nSeguidos = new functions();
									$nSeguidos ->retNSeguidos($_SESSION['id']);*/
									//$docente -> retNSeguidos($_SESSION['id']);
                                    $docente -> retNSeguidos($_SESSION['id']);
								  ?>
								</a>
							</li>
							<li class="list-group-item">
							  <b>Seguidores</b> <a class="pull-right">
								<?php
                                    echo '<a class="pull-right" href="listSeguidores.php?idDocente='.$_SESSION['id'].'">';
									/*$nSeguidores = new functions();
									$nSeguidores ->retNSeguidores($_SESSION['id']);*/
									$docente->retNSeguidores($_SESSION['id']);
								?>
								</a>
							</li>
							<li class="list-group-item">
							  <b>Publicações</b> <a class="pull-right">
								<?php
									/*$nAulas = new functions();
									$nAulas ->retCountAulas($_SESSION['id']);*/
									$docente ->retCountAulas($_SESSION['id']);
								?>
								</a>
							</li>
						  </ul>
							<a href="aula.php" class="btn btn-primary btn-block"><i class="fa fa-book"></i><b> Nova Aula</b></a>
						</div>
						<!-- /.box-body -->
                    </div>

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sobre Mim</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> Formação</strong>
                            <p class="text-muted">
                                <?php
                                    /*$formacao = new functions();
                                    $formacao->retFormacao($_SESSION['id']);*/
                                    $docente->retFormacao($_SESSION['id']);
                                ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Local</strong>
                            <p class="text-muted">
                                <?php
                                    /*$cidade = new functions();
                                    $cidade->retCidadeProfile($_SESSION['id']);*/
                                    $docente ->retCidadeProfile($_SESSION['id']);
                                ?></p>
                            <hr>
                            <strong><i class="fa fa-star margin-r-5"></i> Interesses</strong>
                            <p>
                                <?php
                                    /*$listInteresses = new functions();
                                    $listInteresses ->retInteressesDocente($_SESSION['id']);*/
                                    $docente->retInteressesDocente($_SESSION['id']);
                                ?>
                            </p>
                            <hr>
                            <strong><i class="fa fa-file-text-o margin-r-5"></i> Sobre mim</strong>
                           <p>
                               <?php
                                //echo 'aqui vou aparecer... ';
                                echo '<br/>';
                                    /*$sobreMim = new functions();
                                    $sobreMim ->retSobreMim($_SESSION['id']);*/
                                    $docente ->retSobreMim($_SESSION['id']);
                               ?>
                           </p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-6"> <!-- ALTEREI PARA 6 PARA TESTAR A CRIAÇÃO DE UMA ÁREA DE SUGESTÕES. byDouglas em 7/1/18-->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li><a href="#posts" data-toggle="tab"><i class="fa fa-book"></i> Sua Atividade</a></li>
                            <li class="active"><a href="#feed" data-toggle="tab"><i class="fa fa-bars"></i> Feed</a></li>
                            <li><a href="#config" data-toggle="tab"><i class="fa fa-cog"></i> Configurações</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="posts">
                                <!-- Post -->
                                <div class="list-group" id="aulas">
                                    <!--mostra suas aulas-->
                                </div>
                            </div>
                            <div class="active tab-pane" id="feed">
                                <!-- Post -->
                                <div class="list-group" id="feedAulas">
                                    <!-- mostra feed -->
                                </div>
                            </div>
							
							<!-- Aba de configuração -->

							  <?php include 'tab_config.php';?>
							
							
							<!-- / Aba de configuração -->
					
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <div class="col-md-3">
                    <H3>Sugeridos para você</H3>
                    <?php
                        $docente->retSugestoes($_SESSION['id']);
                    ?>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- gif de loading -->
        <img src="assets/imgs/loadbook.gif" alt="" id="loading" class="content"/>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

	<!-- RODAPE -->

      <?php include 'footer.php';?>

    <!-- / RODAPE -->
	
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="assets/js/jquery-2.2.3.min.js"></script>
<!-- SlimScroll -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/js/bootstrap.js"></script>
<!-- bootstrap datepicker -->
<script src="assets/js/datepicker.js"></script>
<script src="assets/js/datepicker.pt-BR.js"></script>
<!-- Select2 -->
<script src="assets/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="assets/js/jquery.inputmask.js"></script>
<script src="assets/js/jquery.inputmask.extensions.js"></script>
<!-- FastClick -->
<script src="assets/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/app.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/js/demo.js"></script>
<!-- iCheck -->
<script src="assets/js/icheck.js"></script>
<!-- File Input -->
<script src="assets/js/jsFileInput/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/plugins/sortable.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/plugins/purify.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/fileinput.min.js"></script>
<script src="assets/css/cssFileInput/fa/theme.js"></script>
<script src="assets/js/jsFileInput/locales/pt-BR.js"></script>

<script type="text/javascript">
    hide('all');
</script>
	
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
		
		//Date picker
    	$('#datepicker').datepicker({
      		autoclose: true
    	});

	});
</script>
	
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
	

<script type="text/javascript">
    function atualizarAulas() {
        $.ajax({
            //url: 'get_aulas.php', <-- CHAMADA ANTERIOR QUANDO AS AULAS ERAM DIVIDIDAS ENTRE AS DO DOCENTE E AS DOS SEGUIDOS. ALTERADO POR DOUGLAS EM 01/02/2018
            url:'get_aulas_full.php',
            success: function (data) {
                $('#aulas').html(data);
                //alert(data);
            }
        });
    }
    atualizarAulas();
</script>

<script type="text/javascript">
    function atualizaAulasSeguidos() {
        $.ajax({
            url: 'get_aulas_seguidos.php',
            success: function (data) {
                $('#feedAulas').html(data);
            }
        });
    }
    atualizaAulasSeguidos();
</script>

<!--formatação de telefone-->
<script type="text/javascript">
    function mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
    }
    function execmascara(){
        v_obj.value=v_fun(v_obj.value)
    }
    function mtel(v){
        v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
        v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }
</script>

<!--Altera linguagem datepicker para pt-br-->
<script>
    $(function () {
        $('.input-group.date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            viewMode: "years",
            todayHighlight: true,
            autoclose: true
        });
    });
</script>
<script>
    $("#imgUser").fileinput({
        overwriteInitial: true,
        language: "pt-BR",
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        allowedFileExtensions: ["jpg", "png", "gif","jpeg"]
    });
</script>
<script>
    $("#imgCapa").fileinput({
        overwriteInitial: true,
        language: "pt-BR",
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        allowedFileExtensions: ["jpg", "png", "gif","jpeg"]
    });
</script>

</body>
</html>



