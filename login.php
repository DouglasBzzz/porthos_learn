<?php

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Learn&trade; | Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/css/blue.css">
    <!-- favicon	-->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico"/>

    <!-- jquery - link cdn -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


<!--    //verificação de campos preenchidos-->
    <script>
        $(document).ready(function () {


            $('#btn_login').click(function () {

                var campo_vazio = false;

                if ($('#login').val() == '') {
                    $('#login').css({'border-color': '#A94442'});
                    campo_vazio = true;
                } else {
                    $('#login').css({'border-color': '#CCC'});
                }

                if ($('#senha').val() == '') {
                    $('#senha').css({'border-color': '#A94442'});
                    campo_vazio = true;
                } else {
                    $('#senha').css({'border-color': '#CCC'});
                }

                if (campo_vazio) return false;
            });
        });
    </script>


</head>
<body class="hold-transition login-page">
<div class="login-box">
    <a href="index.php" class="logo">
        <div class="login-logo">
            <img src="assets/imgs/learn.png">
        </div>
    </a>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><b>Porthos Learn</b> <i>BETA</i></p>

        <form action="validar_acesso_docente.php" method="post" id="formLogin">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="login" name="login" placeholder="Login">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Lembrar de mim
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="btn_login" class="btn btn-primary btn-block btn-flat">Acessar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <?php
        if ($erro == 1) {
            echo '<font color="#FF0000">Login ou Senha inválido(s)</font>';
        }
        ?>

        <!--        <div class="social-auth-links text-center">-->
        <!--            <p>- OU -</p>-->
        <!--            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Acessar com o-->
        <!--                Facebook</a>-->
        <!--            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Acessar com o-->
        <!--                Google+</a>-->
        <!--        </div>-->
        <!-- /.social-auth-links -->

        <a href="inscrevase.php" class="text-center"><b>> Não tem uma conta? Cadastre-se.</b></a><br>
        <a href="recuperasenha.php">> Esqueci minha senha</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="assets/js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/js/bootstrap.js"></script>
<!-- iCheck -->
<script src="assets/js/icheck.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
