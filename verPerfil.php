<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 10/09/2017
 * Time: 14:26
 */

session_start();
require_once('db.class.php');
require_once('functions.php');
include('nFuncoes.php');

$objdb = new db();
$link = $objdb->conecta_mysql();

$docente = new functions();

$userLogado = $_SESSION['id'];

$idDocente = $_GET['idDocente'];


//echo $idDocente;

$sqlCarregaDadosDocenteSeguido = "select d.id as idDocenteSeguido, d.nome, d.email, d.cell, date_format(d.datacadastro,'%d %b %Y') as datacadastro, d.resumo,
                                    d.foto, d.instituicao, gi.descricao, c.descricao as cidade,
                                    case
                                        when d.DATANASCIMENTOPUBLICA = 1 then date_format(d.DATANASCIMENTO,'%d %b %Y')
                                        when d.DATANASCIMENTOPUBLICA = 0 then 'Não disponível'
                                    end as dataNascimento,
                                    case
                                        when d.GENERO = 0 then 'Masculino'
                                        when d.genero = 1 then 'Feminino'
                                        when d.genero = 2 then 'Indefinido'
                                    end as genero
                                    from docente as d
                                    left join cidade as c on c.ID = d.IDCIDADE
                                    left join grauinstrucao as gi on gi.ID = d.IDGRAUINSTRUCAO
                                    where d.ID = $idDocente";

$carrega = mysqli_query($link, $sqlCarregaDadosDocenteSeguido);

if ($carrega) {
    $carregaDadosDocente = mysqli_fetch_array($carrega);
} else {
    echo '<h1>Tivemos problemas para carregar os dados do usuário! Por favor entre em contato</h1>';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/AdminLTE.css">
    <!-- Rotating Card -->
    <link rel="stylesheet" href="assets/css/rotating-card.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/css/blue.css">
    <!-- favicon    -->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/css/all-skins.css">

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini fixed">
<!-- Site wrapper -->
<div class="wrapper">


    <!--    BARRA SUPERIOR - CABEÇALHO  -->

    <?php include 'header.php'; ?>

    <!--  / BARRA SUPERIOR - CABEÇALHO  -->

    <!--    BARRA LATERAL - MENU -->

    <?php include 'sidebar.php'; ?>

    <!--  / BARRA LATERAL - MENU -->


    <div class="content-wrapper content-verperfil">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-user-o"></i> Dados do usuário
            </h1>
        </section>

        <!--  / CONTEUDO PAGINA -->

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-body col-md-4 col-sm-6">
                    <div class="card-container">
                        <div class="card">
                            <div class="front">
                                <div class="cover"
                                     style="background: url('<?php echo '' . retCapa($carregaDadosDocente['idDocenteSeguido']) . ''; ?>') center">
                                </div>
                                <div class="user">
                                    <div class="profile-user-img img-circle"
                                         style="background: url('<?php echo '' . retFoto($carregaDadosDocente['idDocenteSeguido']) . ''; ?>') center">
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="main">
                                        <h3 class="name"> <?php echo '' . $carregaDadosDocente['nome'] . ''; ?></h3>
                                        <p class="profession"> <?php echo '' . $carregaDadosDocente['descricao'] . ''; ?></p>
                                        <p class="text-center"> <?php echo '' . $carregaDadosDocente['instituicao'] . ''; ?></p>

                                        <p class="text-center list-interesses-perfil">
                                            <i class="fa fa-star margin-r-5"></i> Interesses </br>
                                            <?php
                                            $docente->retInteressesDocente($carregaDadosDocente['idDocenteSeguido']);
                                            ?>
                                        </p>
                                    </div>
                                    <div class="footer">
                                        <i class="fa fa-mail-forward"></i> Mais detalhes
                                    </div>
                                </div>
                            </div> <!-- end front panel -->
                            <div class="back">
                                <div class="header">
                                    <h5 class="motto"><?php echo '' . $carregaDadosDocente['cidade'] . ''; ?> | Membro
                                        desde <?php echo '' . $carregaDadosDocente['datacadastro'] . ''; ?></h5>
                                </div>
                                <div class="content">
                                    <div class="main">
                                        <div class="stats-container">
                                            <h4 class="text-center">Resumo Pessoal</h4>
                                            <?php
                                                if(isset($carregaDadosDocente['dataNascimento'])){
                                                    echo 'Data de Nascimento: '.$carregaDadosDocente['dataNascimento'].'';
                                                }
                                            ?>
                                            <p class="text-center card-resumo"><?php echo '' . $carregaDadosDocente['resumo'] . ''; ?></p>
                                        </div>
                                        <div class="stats-container">
                                            <div class="stats">
                                                <?php echo '<a href="listSeguidores.php?idDocente=' . $carregaDadosDocente['idDocenteSeguido'] . '">'; ?>
                                                <h4>
                                                    <?php
                                                    $media = new functions();
                                                    $media->retNSeguidores($carregaDadosDocente['idDocenteSeguido']);
                                                    ?>
                                                </h4>
                                                <p> Seguidores </p>
                                                </a>
                                            </div>
                                            <div class="stats">
                                                <?php echo '<a href="listSeguidos.php?idDocente=' . $carregaDadosDocente['idDocenteSeguido'] . '">'; ?>
                                                <h4>
                                                    <?php
                                                    $media = new functions();
                                                    $media->retNSeguidos($carregaDadosDocente['idDocenteSeguido']);
                                                    ?>
                                                </h4>
                                                <p>
                                                    Seguindo
                                                </p>
                                                </a>
                                            </div>
                                            <div class="stats">
                                                <?php echo '<a href="#">'; ?>
                                                <h4>
                                                    <?php
                                                    $media = new functions();
                                                    $media->retCountAulas($carregaDadosDocente['idDocenteSeguido']);
                                                    ?>
                                                </h4>
                                                <p>
                                                    Publicações
                                                </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php

                    //$iddocente = $_SESSION['id'];

                    $sql2 = "select DISTINCT d.ID, d.NOME, d.LOGIN, d.EMAIL, s.ID as idTbSeguidores, s.IDSEGUIDO, s.IDSEGUIDOR, 
                             s.DATACOMECOUSEGUIR, s.DATADEIXOUDESEGUIR, s.seguindo,
                             case
                              when s.seguindo is null then 0
                              when s.seguindo = 1 then 1
                             else 0
                             end as seguindo2 
                             from docente as d
                             left join seguidores as s on (s.IDSEGUIDOR = $userLogado and d.ID = s.IDSEGUIDO)
                             where (d.ID = $idDocente ) and d.ID <> $userLogado and d.ID > 0 and situacao = 1
                                    group by d.id 
                                    order by d.NOME, d.id";

                    $resultadoid = mysqli_query($link, $sql2);

                    if ($resultadoid) {
                        while ($registro = mysqli_fetch_array($resultadoid, MYSQLI_ASSOC)) {
                            if (isset($registro['seguindo2']) && $registro['seguindo2'] == 1) {
                                $seguindo = 'S';
                            } else {
                                $seguindo = 'N';
                            }

                            $btnSeguir = 'block';
                            $btnDeixarSeguir = 'block';

                            if ($seguindo == 'S') {
                                $btnSeguir = 'none';
                            } else {
                                $btnDeixarSeguir = 'none';
                            }

                            echo '<div class="center-block"> ';
                            echo '<button type="button" class="btn btn-primary btn_seguir" id="btn_seguir_' . $registro['ID'] . '" 
                                data-iddocenteseguido="' . $registro['ID'] . '" style="display: ' . $btnSeguir . '" ><i class="fa fa-user-plus"></i> Seguir</button>';

                            echo '<button type="button" style="display:' . $btnDeixarSeguir . '"  class="btn btn-danger center-block btn_deixar_seguir " 
                                id="btn_deixarseguir_' . $registro['ID'] . '" data-iddocenteseguido="' . $registro['ID'] . '" ><i class="fa fa-user-times"></i> Deixar de Seguir</button>';
                            echo '</div>';
                            echo '</p>';
                            echo '<div class="clearfix"></div>';

                        }
                    } else {
                        echo 'Erro ao consultar usuários...';
                    }

                    ?>
                </div>
            </div>
                    <div class="box-body col-md-4">
                        <h2>Últimas publicações</h2>
                        <div class="box-body">
                            <?php
                            $sql = "Select d.LOGIN,d.nome, date_format(a.DATAINCLUSAO,'%d %b %Y %T') as DATAINCLUSAO, a.ID as idAula,a.TITLE, a.DESCCONTEUDO 
                                from aula as a 
                                inner join docente as d 
                                on d.ID = a.IDDOCENTE 
                                where a.IDDOCENTE = $idDocente and d.SITUACAO = 1 and a.PUBLICA = 1
                                order by a.DATAINCLUSAO DESC limit 3";

                            $resultadoid = mysqli_query($link, $sql);
                            if ($resultadoid) {
                                while ($registro = mysqli_fetch_array($resultadoid, MYSQLI_ASSOC)) {
                                    $_SESSION['idAula'] = $registro['idAula'];
                                    $nComentariosAula = new functions();
                                    //$nComentariosAula->retNcomentariosAula($_SESSION['idAula']);

                                    if ($idDocente <> $userLogado) {
                                        echo '<form action="verAula.php" method="get">';
                                    } else {
                                        echo '<form action="docenteVisaoAula.php" method="get">';
                                    }

                                    echo '<div class="post">
                                    <div class="user-block">
                                        <div class="img-circle img-bordered-sm"
                                            style="background: url(' . retFoto($idDocente) . ') center">
                                            <span class="username">
                                                <a href="#">' . $registro['nome'] . '</a>
                                                <a href="#" class="pull-right btn-box-tool"></a>
                                            </span>
                                            <span class="description">' . $registro['DATAINCLUSAO'] . '</span>
                                            <input type="hidden" value="' . $registro['idAula'] . '" name="idAula"/>
                                        </div>
                                    </div>
                                    <h4><p>' . $registro['TITLE'] . '</p> </h4>
                                    <p>' . $registro['DESCCONTEUDO'] . '</p>
                                    <ul class="list-inline">
                                        <li>
                                            <button type="submit" class="btn btn-xs"><i class="fa fa-eye"></i> Visualizar</button>
                                        </li>
                                        <li>';
                                    echo '<button type="button" class="btn btn-xs"><i class="fa fa-comments-o">' . $nComentariosAula->retNcomentariosAula($registro['idAula']) . '</i></button>';
                                    echo '</li>
                                    </ul>
                                    </div>
                                </form>';
                                }
                            } else {
                                echo 'Ops! Tivemos um problema para recuperar as suas aulas. Por favor, entre em contato.';
                            }
                            ?>
                        </div>
                        <?php
                        echo '<form action="fullAulas.php" method="post">';
                        echo '<input type="hidden" value="' . $idDocente . '" name="idDocente">';
                        echo '<button type="submit" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Ver Mais</button>';
                        echo '</form>';
                        ?>
                    </div>
                    <div class="box-body col-md-4">
                        <h2>Média dos conteúdos</h2>
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>
                                    <?php
                                    $media = new functions();
                                    $media->retMediaDocente($idDocente);
                                    ?>
                                </h3>
                                <p>Média de avaliações das publicações</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-star"></i>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <!--Footer-->
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

    <?php include 'footer.php'; ?>

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


<!-- alteração do rotating card -->
<script type="text/javascript">
    $().ready(function () {
        $('[rel="tooltip"]').tooltip();

    });

    function rotateCard(btn) {
        var $card = $(btn).closest('.card-container');
        console.log($card);
        if ($card.hasClass('hover')) {
            $card.removeClass('hover');
        } else {
            $card.addClass('hover');
        }
    }

    $('.btn_seguir').click(function () {
        var vIdSeguido = $(this).data('iddocenteseguido');

        $('#btn_seguir_' + vIdSeguido).hide();
        $('#btn_deixarseguir_' + vIdSeguido).show();

        /*
        $('#btn_seguir'+vIdSeguido).show();
        $('#btn_deixarseguir'+vIdSeguido).show(); */ //vFuncional de exibição dos dois botões. < by Douglas

        $.ajax({
            url: 'seguir.php',
            method: 'post',
            data: {idSeguido: vIdSeguido},
            /*success: function (data) {
                alert('Você agora está seguindo esse usuário!');
            }*/
        });
    });

    $('.btn_deixar_seguir').click(function () {
        var vIdSeguido = $(this).data('iddocenteseguido');

        $('#btn_seguir_' + vIdSeguido).show();
        $('#btn_deixarseguir_' + vIdSeguido).hide();

        /*$('#btn_seguir'+vIdSeguido).show();
        $('#btn_deixarseguir'+vIdSeguido).show();*/ //comentado by Douglas

        $.ajax({
            url: 'deixarSeguir.php',
            method: 'post',
            data: {idSeguidoNao: vIdSeguido},
            /*success: function (data) {
                alert('Você não está mais seguindo esse usuário!');
            }*/
        });

    })

</script>

</body>
</html>
