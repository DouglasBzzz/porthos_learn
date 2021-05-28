<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 07/09/2017
 * Time: 12:57
 */

    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: profile.php');
    }
    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $idAula = $_POST['idAula'];

    $sqlCarregaDadosAula = "SELECT DISTINCT a.ID, a.TITLE, a.DESCCONTEUDO, 
                            date_format(a.DATAINCLUSAO,'%d %b %Y') as datainclusao,
                            a.IDDOCENTE, d.nome, f.ID as idFaixa, f.descricao as descricaoFaixa, 
                            ta.ID as idTpAula, ta.descricao as descricaoTpAula, 
                            a.NALUNOSIDEAL, a.DESCRICAO, a.PUBLICA,
                            case
                            when a.LINKWEB = '' or a.LINKWEB is null then 'Não existe link externo para essa atividade.'
                            else a.LINKWEB
                            end as linkAtv
                            from aula as a 
                            inner join docente as d on d.ID = a.IDDOCENTE
                            inner join seguidores as s on s.IDSEGUIDO = a.IDDOCENTE
                            inner join tipoaula as ta on ta.id = a.IDTIPOAULA
                            inner join faixaetaria as f on f.ID = a.IDFAIXAETARIARECOMENDADA
                            where a.ID = $idAula";

    $dadosAula = mysqli_query($link, $sqlCarregaDadosAula);

    if($dadosAula){
        while($aula = mysqli_fetch_array($dadosAula, MYSQLI_ASSOC)){
            $aulaTitulo = $aula['TITLE'];
            $descConteudo = $aula['DESCCONTEUDO'];
            $nAlunosIdeal = $aula['NALUNOSIDEAL'];
            $descricao = $aula['DESCRICAO'];
            $linkExterno = $aula['linkAtv'];
            $publica = $aula['PUBLICA'];
            $idTipoAula = $aula['idTpAula'];
            $descTipoAula = $aula['descricaoTpAula'];
            $idFaixa = $aula['idFaixa'];
            $descFaixa = $aula['descricaoFaixa'];
        }
    }else{
        echo 'problema para recuperar dados da aula selecionada...</br>';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn&trade; | Edição de Aula</title>
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


    <!--	CONTEUDO AULA	  -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                <i class="fa fa-edit"></i>  Editar aula
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="box box-info">
                <div class="box-body">
                    <?php
                    echo '<form action="updateAula.php" method="post" id="formCadPlanoAula" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" id="titulo" name="title" value="'.$aulaTitulo.'"
                                   placeholder="Título da Aula" maxlength="100" required>
                                   
                            <input type="hidden" class="form-control" id="idAula" name="idAula" value="'.$idAula.'">
                        </div>
                        <div class="form-group">
                            <textarea class="textarea" name="descConteudo" id="descConteudo"
                                      placeholder="Descrição do conteúdo" maxlength="300"
                                      style="width: 100%; height: 70px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                      required>'.$descConteudo.'</textarea>
                        </div>';
                    ?>

                        <div class="form-group">
                            <?php
/*                            require_once('db.class.php');

                            $objDb = new  db();
                            $link = $objDb->conecta_mysql();
                            //$con = mysqli_connect('localhost','root','root','porthoslearn');

                            if (mysqli_connect_errno()) {
                                echo 'falha na conexao' . mysqli_connect_error();
                            }
                            $result = mysqli_query($link, "select id, descricao from interesse");

                            echo "<select class='form-control select2' data-placeholder='Selecione o(s) foco(s) da aula' multiple='multiple' name='listInteresses[]' id='interesses' style='width: 100%;' required>";

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                            echo "</select>";
                            mysqli_close($link);
                            */?>
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
                            echo "<option value = '".$idFaixa."' selected>".$descFaixa."</option>";
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
                            echo "<option value = '".$idTipoAula."' selected>".$descTipoAula."</option>";

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                            }
                            echo "</select>";
                            mysqli_close($link);
                            ?>
                        </div>

                        <?php
                            echo '<div class="form-group">
                                    <input type="number" min="1" step="1" class="form-control" id="nAlunosIdeal" value="'.$nAlunosIdeal.'"
                                       name="nAlunosIdeal" placeholder="Numero de alunos ideal" required>
                                  </div>';
                        ?>

                        <!--	Conteúdo	-->
                        <?php
                            echo '<div class="form-group">
                                <textarea name="editor1" id="editor1" rows="20" cols="80">
                                    '.$descricao.'
                                </textarea>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="linkAtvWeb" name="linkAtvWeb" value="'.$linkExterno.'"
                                       placeholder="Links externos">
                            </div>';
                        ?>

                        <!-- Checkbox -->

                        <?php
                            if($publica==1){
                                echo "<label class='control-label'>Aula pública: </label>";
                                echo "<input type='hidden' id='publica' name='publica' value='0'/>";
                                echo "<input type='checkbox' id='publica' name='publica' value='1' checked='checked'/>";
                            }
                            if($publica==0){
                                echo "<label class='control-label'>Aula pública: </label>";
                                echo "<input type='hidden' id='publica' name='publica' value='0' checked='checked'/>";
                                echo "<input type='checkbox' id='publica' name='publica' value='1'/>";
                            }
                        ?>

                        <!--<label class="control-label">Aula pública: </label>
                        <input type='hidden' id='publica' name='publica' value='0'/>
                        <input type='checkbox' id='publica' name='publica' value='1' checked="checked"/>-->

                        <button id="btnInfo" class="btn btn-info btn-xs">?</button>


                        <!--	Botão salvar  -->
                        <div class="form-group">
                            <button type="submit" value="salvar" class="pull-right btn btn-primary">Salvar <i
                                    class="fa fa-floppy-o"></i></button>
                        </div>

                    </form>
                </div>
            </div>

        </section>
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
        $('.btn-info').tooltip({title:"<strong>Quando sua aula estiver pública, qualquer usuário poderá encontrá-la e " +
        "realizar comentários e avaliações acerca do conteúdo públicado</strong>",html: true, placement: "bottom"});
    });

</script>

</body>
</html>

