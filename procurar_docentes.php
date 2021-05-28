<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: index.php?erro=1');
    }
    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Porthos Learn | HomeTemp</title>
    <!-- jquery - link cdn -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- bootstrap - link cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="val.js"></script>

    <script type="text/javascript">
        $(document).ready( function(){
            //associar o evento de click ao botão
            $('#btn_procurar_docente').click( function(){
                if($('#nome_docente').val().length > 0){
                    $.ajax({
                        url: 'get_docentes.php',
                        method: 'post',
                        data: $('#form_procurar_docente').serialize(),
                        success: function(data) {
                            //alert(data);
                            $('#docentes').html(data);
                        }
                    });
                }
            });
        });
    </script>

</head>
<body>
<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<img src="http://ap.imagensbrasil.org/images/2017/05/23/book_flat_book_png_book_icon_web_icon_png.png"/>-->
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="profile.php">Voltar para Home</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<br/>
<br/>
<div class="container">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>
                    <?=
                    $_SESSION['login'];
                    ?>
                </h4>
                <hr/>
                <div class="col-md-6">
                    Class
                </div>
                <div class="col-md-6">
                    Followers
                </div>
            </div>
        </div>
        <span class="input-group-btn">
            <button class="btn btn-default" id="novaAula" type="button"><a href="aula.php">Criar nova aula</a></button>
        </span>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel panel-body">
                <form class="input-group" id="form_procurar_docente">
                    <input type="text" id="nome_docente" name="nome_docente" class="form-control" placeholder="Quem você está procurando?"/>
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="btn_procurar_docente" type="button">Buscar</button>
                    </span>
                </form>
            </div>
        </div>
        <div class="list-group" id="docentes">
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
</body>
</html>