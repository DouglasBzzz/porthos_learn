<?php
session_start();
if(!isset($_SESSION['login'])){
    header('Location: profile.php');
}
require_once ('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Learn&trade; | Visualizar Aula</title>
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
    <!-- FileInput -->
    <link href="assets/css/cssFileInput/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

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


    <!-- CONTEUDO PAGINA -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <div class="list-group" id="dadosAula">

                            <?php

                            if(!isset($_SESSION['login'])){
                                header('Location: index.php?erro=1');
                            }

                            require_once ('db.class.php');

                            $idAula = $_GET['idAula'];
                            $iddocente = $_SESSION['id'];

                            $objdb = new db();
                            $link = $objdb ->conecta_mysql();

                            $sqlDadosAula = "SELECT DISTINCT a.ID, a.TITLE, a.DESCCONTEUDO, date_format(a.DATAINCLUSAO,'%d %b %Y') as datainclusao,
                                            a.IDDOCENTE, d.nome, f.descricao as descricaoFaixa, ta.descricao as descricaoTpAula, a.NALUNOSIDEAL, a.DESCRICAO, 
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


                            $sqlContadorAulaAcessos = "select count(distinct iddocente) as nAcessos, idaula 
                                                       from aulaacessos 
                                                       where idaula = $idAula";

                            $carregaNacessos = mysqli_query($link, $sqlContadorAulaAcessos);
                            if ($carregaNacessos){

                                $contadorAcessos = mysqli_fetch_array($carregaNacessos);
                                if(isset($contadorAcessos['nAcessos']) && $contadorAcessos['nAcessos']>0){
                                    $reg = $contadorAcessos['nAcessos'];
                                }else{
                                    $reg = 0;
                                }

                            }


                            $resultado = mysqli_query($link,$sqlDadosAula);

                            if ($resultado){
                                while ($registroAula = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
                                    echo '<div class="box-noborder box-widget-settings widget-user">
                                        <div class="widget-user-header bg-black "
                                            style="background: url('.retCapa($registroAula['IDDOCENTE']).') center">
                                            <!-- titulo do conteudo-->
                                            <h3 class="viewaula-title">'.$registroAula['TITLE'].'</h3>
                                            <!-- autor do conteudo-->
                                            <h5 class="widget-user-desc">Por: '.$registroAula['nome'].'</h5>
                                        </div>
                                        <!-- data de inclusao-->
                                        <h5 class="viewaula-date"> Criado em: '.$registroAula['datainclusao'].' </h5>
                                        <!-- descrição breve de conteudo-->
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <blockquote>
                                                    <p>'.$registroAula['DESCCONTEUDO'].'</p>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <br/>
                                        <!-- info box-->
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <!-- nivel de ensino -->
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-red"><i class="fa fa-graduation-cap"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Nível de Ensino:</span>
                                                        <span class="info-box-number">'.$registroAula['descricaoFaixa'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- numero de alunos -->
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Número de Alunos:</span>
                                                        <span class="info-box-number">'.$registroAula['NALUNOSIDEAL'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- tipo da atividade -->
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-green"><i class="fa fa-pencil-square-o"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Atividade:</span>
                                                        <span class="info-box-number">'.$registroAula['descricaoTpAula'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- numero de visualizações -->
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-aqua"><i class="fa fa-eye"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Visualizações</span>
                                                        <span class="info-box-number">'.$reg.'</span>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <!-- conteudo -->
                                        <div class="box box-solid">
                                            <div class="box-body">
                                                <blockquote>
                                                    '.$registroAula['DESCRICAO'].'
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- links uteis externos -->
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-link"></i>                       
                                            <h4 class="box-title">Links úteis</h4>
                                        </div>
                                        <div class="box-body">';
                                    if($registroAula['linkAtv']=='Não existe link externo para essa atividade.'){
                                        echo "Não existem links para essa atividade.";
                                    }else{
                                        echo "<a href=".$registroAula['linkAtv']." target='_blank'>".$registroAula['linkAtv']."</a>";
                                    }
                                    //printf("<a href=".$registroAula['linkAtv']." target='_blank'>%s </a>", $registroAula['linkAtv']);
                                    echo'</div>
                                    </div>';
                                }
                            }
                            //areas de conhecimento - interesses
                            $sqlInteressesAula = "SELECT i.id AS idinteresse, i.descricao, a.id AS idaula 
                                                FROM aulainteresses AS ai
                                                inner join interesse as i on i.ID = ai.idinteresse
                                                inner join aula as a on a.ID = ai.idaula
                                                where ai.idaula = $idAula";

                            $resultadoInteresses = mysqli_query($link,$sqlInteressesAula);

                            if ($resultadoInteresses){
                                echo'<div class="box box-solid">
                                    <div class="box-header with-border">
                                        <i class="fa fa-star"></i>                       
                                        <h4 class="box-title">Áreas de Conhecimento</h4>
                                    </div>
                                    <div class="box-body">
                                        <p>';
                                while ($reg=mysqli_fetch_array($resultadoInteresses, MYSQLI_ASSOC)){
                                    echo'<span class="label label-primary" style="margin-right: 5px">'. $reg['descricao'].'</span>';
                                }
                                echo '</p>
                                        </div>
                                </div>';
                            }

                            //anexos
                            echo '<form class="form-group">
                                <div class="box-header with-border">
                                    <i class="fa fa-paperclip"></i>                       
                                    <h4 class="box-title">Anexos</h4>
                                </div>
                                <div class="container">
                                    <label class="control-label">Esses são os anexos da aula:</label>
                                    <br/>';
                            $sqlAulaId = "select convert(a.id, char(11)) as aulaId, a.title, d.id as idDocente
                                                      from aula as a
                                                      inner join docente as d on d.id = a.IDDOCENTE
                                                      where a.id = $idAula";

                            $retIdAula = mysqli_query($link, $sqlAulaId);

                            $sqlCarregaCaminho = "select distinct a.path as caminho, aula.id as idAula
                                                              from arquivo as a
                                                              inner join aula on aula.ID = a.IDAULA
                                                              where aula.id = $idAula";

                            $retCaminho = mysqli_query($link, $sqlCarregaCaminho);

                            //verificando se a aula existe, para carregar os arquivos.

                            if ($retIdAula){
                                $vIdAula = mysqli_fetch_array($retIdAula);
                                $caminho = './AULAS/'."$vIdAula[aulaId]";
                                //echo $caminho;

                                if($handle = opendir($caminho)){
                                    while($entry = readdir($handle)){
                                        if($entry !='..'&& $entry !='.'){
                                            //$ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
                                            //echo '<br/>';

                                            echo '<a href="'.$caminho.'/'.$entry.'" download>'.$entry.'</a>';
                                            //echo "<a href='$caminho/' download>$entry</a>";
                                            //echo "<a href = './AULAS/232/' download>$entry</a>";
                                            echo "<br/>";
                                        }
                                    }
                                    closedir($handle);
                                }
                            }
                            //verificando se a aula existe, para carregar os arquivos. -- fechado

                            echo '<br/>
                                </div>
                            </form>';


                            //avaliacao
                            echo '<div class="box-header with-border">
                                <form class="form-group" action="registraAvaliacao.php" method="GET">
                                    <div class="form-group">
                                        <legend>Avaliações</legend>
                                        <input type="hidden" name="idAula" id="idAula" value="'.$idAula.'">';

                            //media de avaliacoes
                            echo'<div class="col-lg-3 col-xs-12 pull-right">
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3>';
                            $media = new functions();
                            $media ->retMediaAula($idAula);
                            echo'</h3>
                                                    <p>Média de avaliações da aula</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-star"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">Vote neste conteúdo</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>';

                            echo '<form name="formMandaComentarios" method="get" id="idMandaComentarios" action="registraComentario.php">
                                <legend>Comentários</legend>
                                <div class="form-group margin-bottom-none">
                                    <div class="input-group">
                                        <input type="hidden" name="idAula" id="idAula" value="'.$idAula.'">
                                        <input class="form-control" placeholder="Deixe seu comentário" name="textComentario" id="idTextComentario">
                                        <span class="input-group-btn">
                                            <button type="submit" name="btnComenta" id="btnComenta" class="btn btn-primary pull-right"><i class="fa fa-commenting"></i> Comentar</button>
                                        </span>
                                    </div>
                                    <div class="col-sm-3">
                                        
                                    </div>
                                </div>
                            </form>';

                            echo '<form name="formComentarios" method="post" id="idFormComentarios" action="registraComentario.php">
                                <br/>
                                <div class="tab-pane" id="timeline">
                                    <ul class="timeline timeline-inverse">';

                            $comentarios = new functions();
                            $comentarios->retComentariosAula($idAula);

                            echo '<li>
                                            <i class="fa fa-clock-o"></i>
                                        </li>
                                    </ul>
                                </div>
                            </form>';

                            ?>

                        </div>
                    </div>
                    <!--<div class="box-body" id="idAula">
                    </div>-->
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <form action="updateAulaVisual.php" method="post" class="form-group pull">
                            <?php echo '<input type="hidden" name="idAula" id="idAula" value="'.$idAula.'">'; ?>
                            <button type="submit" class="pull-left btn btn-primary"><i class="fa fa-edit"></i> Editar</button>
                        </form>
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
<!-- File Input -->
<script src="assets/js/jsFileInput/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/plugins/sortable.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/plugins/purify.min.js" type="text/javascript"></script>
<script src="assets/js/jsFileInput/fileinput.min.js"></script>
<script src="assets/css/cssFileInput/fa/theme.js"></script>
<script src="assets/js/jsFileInput/locales/pt-BR.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //associando evento ao click do botao...
        $('#btnComenta').click(function(){
            if ($('#idTextComentario').val().length>0){
                $.ajax({
                    url:'registraComentario.php',
                    method:'post',
                    data:$('#formCarregaComentarios').serialize(),
                    success: function(data){
                        $('#idTextComentario').val('');
                        atualizaComentarios();
                    }
                });
            }
        });

        function atualizaComentarios(){
            //carrega os comentarios
            $.ajax({
                url: 'get_comentarios.php',
                success: function(data){
                    $('#comentarios').html(data);
                }
            });
        }
        atualizaComentarios();
    });
</script>

</body>
</html>
