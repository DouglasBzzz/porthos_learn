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
    <title>Learn&trade; | Nova Aula</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/86f1dc7ee7.js"></script>
    <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
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
<!-- Site wrapper -->
<div class="wrapper">


    <!--	BARRA SUPERIOR - CABEÇALHO	-->

        <?php include 'header.php';?>

    <!--  / BARRA SUPERIOR - CABEÇALHO	-->

    <!--	BARRA LATERAL - MENU -->
	
        <?php include 'sidebar.php';?>
	
    <!--  / BARRA LATERAL - MENU -->
	
	
    <!--	CONTEUDO AULA	  -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                <i class="fa fa-book"></i>  Nova aula
            </h1>
        </section>

        <!-- Main content -->
        <section class="content" id="all">
            <div class="box box-info">
                <div class="box-body">

<!--                    <div class="box box-warning collapsed-box">-->
<!--                        <div class="box-header with-border">-->
<!--                            <h3 class="box-title">Orientações</h3>-->
<!--                            <div class="box-tools pull-right">-->
<!--                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="box-body">-->
<!--                            Sempre coloque referências-->
<!--                        </div>-->
<!--                    </div>-->

                    <form action="registra_aula.php" method="post" id="formCadPlanoAula" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" id="titulo" name="title"
                                   placeholder="Título da Aula" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <textarea class="textarea" name="descConteudo" id="descConteudo"
                                      placeholder="Descrição do conteúdo" maxlength="300"
                                      style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                      required></textarea>
                        </div>

                        <div class="form-group">
                            <?php
                            require_once('db.class.php');

                            $objDb = new  db();
                            $link = $objDb->conecta_mysql();
                            //$con = mysqli_connect('localhost','root','root','porthoslearn');

                            if (mysqli_connect_errno()) {
                                echo 'falha na conexao' . mysqli_connect_error();
                            }
                            $result = mysqli_query($link, "select id, descricao from interesse order by DESCRICAO;");

                            echo "<select class='form-control select2' data-placeholder='Selecione o(s) foco(s) da aula' multiple='multiple' name='listInteresses[]' id='interesses' style='width: 100%;' required>";

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                            echo "</select>";
                            mysqli_close($link);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                            require_once('db.class.php');

                            $objDb = new  db();
                            $link = $objDb->conecta_mysql();

                            if (mysqli_connect_errno()) {
                                echo 'falha na conexao' . mysqli_connect_error();
                            }
                            $result = mysqli_query($link, "select id, descricao from faixaetaria where ATIVO = 1");

                            echo "<select class='form-control select2' data-placeholder='Selecione o nível de ensino' style='width: 100%' name='faixaEtaria' id='faixaEtaria' required>";

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                            echo "</select>";
                            mysqli_close($link);
                            ?>
                        </div>

                        <div class="form-group">
                            <?php
                            require_once('db.class.php');

                            $objDb = new  db();
                            $link = $objDb->conecta_mysql();

                            if (mysqli_connect_errno()) {
                                echo 'falha na conexao' . mysqli_connect_error();
                            }
                            $result = mysqli_query($link, "select id, descricao from tipoaula where ATIVO = 1");

                            echo "<select class='form-control select2' data-placeholder='Selecione o tipo da aula' style='width: 100%' name='tipoAula' id='tipoAula' required>";

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                            echo "</select>";
                            mysqli_close($link);
                            ?>
                        </div>

                        <div class="form-group">
                            <input type="number" min="1" step="1" class="form-control" id="nAlunosIdeal"
                                   name="nAlunosIdeal" placeholder="Numero de alunos ideal" required>
                        </div>

                        <!--	Conteúdo	-->
                        <div class="form-group">
                            <textarea name="editor1" id="editor1" rows="20" cols="80">
                                <h1>Digite o conteúdo aqui</h1>
                                <p><strong>Insira, </strong><em>edite</em><strong> e</strong><s> formate</s><strong> seu conte&uacute;do como desejar</strong></p>
                            </textarea>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="linkAtvWeb" name="linkAtvWeb"
                                   placeholder="Links externos">
                        </div>

                        <!--anexos byDouglas em 30/07/2017 -->
                        <div class="form-group">
                            <label class="control-label">Selecione os arquivos para anexar a aula:</label>
                            <!--<span class="hidden-xs"> Buscar... </span>-->
                            <input id="arquivos" name="arquivos[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true">
                            <!--<input type="submit" value="Enviar arquivo" />-->
                            <label class="desc-label">Tamanho máximo: 20mB</label>
                            <br/>
                            <br/>
                            <!--<form enctype="multipart/form-data" action="upload.php" method="POST"></form>-->
                        </div>

                        <!-- Checkbox -->
                        <label class="control-label" id="labelAulaPublica">Aula pública: </label>
                        <input type='hidden' id='publica' name='publica' value='0'/>
                        <input type='checkbox' id='publica' name='publica' value='1' checked="checked"/>

                        <input type="button" id="btnInfo" class="btn btn-info btn-xs" value="?"/>


                        <!--	Botão salvar  -->
                        <div class="form-group">
                            <button type="submit" value="salvar" class="pull-right btn btn-primary">Salvar <i
                                        class="fa fa-floppy-o"></i></button>
                        </div>

                    </form>
                </div>
            </div>

        </section>
        <!-- gif de loading -->
        <img src="assets/imgs/loadbook.gif" alt="" id="loading" class="content"/>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--	/ CONTEUDO AULA	  -->

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
<!-- Select2 -->
<script src="assets/js/select2.full.min.js"></script>
<!-- FastClick -->
<script src="assets/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/app.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/js/demo.js"></script>
<!-- iCheck 1.0.1 -->
<script src="assets/js/icheck.js"></script>
<!-- CK Editor -->
<!--<script src="https://cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>-->
<script src="ckeditor/ckeditor.js"></script>
<!-- File Input -->
<script src="assets/js/jsFileInput/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/plugins/sortable.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/plugins/purify.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/fileinput.min.js"></script>
<script src="assets/css/cssFileInput/fa/theme.js"></script>
<script src="assets/js/jsFileInput/locales/pt-BR.js"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    });
</script>

<script>
    $(document).ready(function(){
        //info das aulas publicas...
       $('.btn-info').tooltip({title:"<strong>Quando sua aula estiver pública, qualquer usuário poderá encontrá-la e " +
       "realizar comentários e avaliações acerca do conteúdo públicado</strong>",html   : true, placement: "bottom"});
    });
</script>

<script>
    $("#arquivos").fileinput({
        overwriteInitial: true,
        language: "pt-BR",
        maxFileSize: 20000,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        allowedFileExtensions: ["txt", "doc", "docx", "pdf","png","jpg","gif", "jpeg", "xls","xlsx", "ppt","pptx", "rar", "zip", "7z", "odt", "otp", "odf","ods","ots","odp"]
    });
</script>

</body>
</html>
