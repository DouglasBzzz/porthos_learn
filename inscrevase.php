<?php
if(isset($dados_usuario['login'])) {

    // $_SESSION['id'] = $dados_usuario['id'];
    $_SESSION['login'] = $dados_usuario['login'];
    $_SESSION['nome'] = $dados_usuario['nome'];
    $_SESSION['email'] = $dados_usuario['email'];
}
$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

/*global $error_insc;
if ($erro == 1) {
    $error_insc = "E-mail já cadastro!";
} else if ($erro == 2){
    $error_insc = "Login já cadastrado!";
} else if ($erro == 3){
    $error_insc = "Erro ao Cadastrar, contate-nos!".mysqli_error($link);
} else{
    $error_insc = "";
}*/

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Learn&trade; | Cadastrar</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="assets/css/SweetAlert/sweetalert.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets/css/blue.css">
    <!-- favicon	-->
    <link rel="shortcut icon" href="assets/imgs/favicon.ico" />
    <!--  jquery  -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!--  validacoes  -->
    <script src="assets/js/validacoes.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                 radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</head>
<body class="hold-transition register-page">
<form  action="registraDocente.php" method="post" id="formCadastrarse" name="formCadastrarse">
<div class="register-box">
    <a href="index.php" class="logo">
        <div class="login-logo">
            <img src="assets/imgs/learn.png">
        </div>
    </a>

   <div class="register-box-body">
        <p class="login-box-msg">Entre para o grupo dos apaixonados por educação ♥</p>
        <?php
        //echo  "<div> <p class='bg-danger' style='color:#9f191f;text-align:center'>".$error_insc."</p> </div>";
        ?>

            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome e Sobrenome"
                       onblur="ConfereCampos('nome', document.getElementById('nome').value);" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div id="campo_nome"></div>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="login" name="login" placeholder="Login"
                       onblur="ConfereCampos('login', document.getElementById('login').value);" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                <div id="campo_login"></div>
<!--                <div class="help-block with-errors"></div>-->
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                       onblur="ConfereCampos('email', document.getElementById('email').value);"  required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div id="campo_email"></div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Senha (Mínimo 6 caracteres)"
                       onblur="ConfereCampos('inputPassword', document.getElementById('inputPassword').value);" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div id="campo_inputPassword"></div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="inputConfirm" placeholder="Confirme sua Senha..."
                       onblur="ConfereCampos('inputConfirm', document.getElementById('inputConfirm').value);" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div id="campo_inputConfirm"></div>
            </div>

       <div class="form-group">
           <h5 for="inputDataNasc">Data de Nascimento</h5>
               <div class="form-group">
                   <select name="dia" class="custom-select" onblur="ConfereCampos('dia', document.getElementById('dia').value);" required></select>
                   <select name="mes" class="custom-select" onblur="ConfereCampos('mes', document.getElementById('mes').value);" required></select>
                   <select name="ano" class="custom-select" onblur="ConfereCampos('ano', document.getElementById('ano').value);" required></select>
               </div>
               <div id="campo_datanasc"></div>
           </div>

            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="genero" value="0" required>
                        Masculino
                    </label>
                    <label>
                        <input type="radio" name="genero" value="1" required>
                        Feminino
                    </label>
                    <label>
                        <input type="radio" name="genero" value="2" required>
                        Outro
                    </label>
               </div>
          <div class="row">
                <div class="form-group">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" data-error="Para continuar você deve aceitar os termos de uso!" required> Eu li e concordo com os termos de <a href="termos.php" target='_blank'>uso e privacidade</a>.
                            </label>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" value="salvar" id="cadastrar" name="cadastrar" class="btn btn-primary btn-block btn-flat">Cadastrar</button>
                </div>
            </div>


<!--        <div class="social-auth-links text-center">-->
<!--            <p>- OU -</p>-->
<!--            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Conecte-se com o-->
<!--                Facebook</a>-->
<!--            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Conecte-se com o-->
<!--                Google+</a>-->
<!--        </div>-->
                <a href="login.php" class="text-center">> Já sou um membro. <b>Fazer Login.</b></a>
    </div>
  </div>
</form>
    <!-- /.form-box -->
<!-- /.register-box -->
<script src="bootstrap/validator.min.js"></script>
<!-- jQuery 2.2.3 -->
<script src="assets/js/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/js/bootstrap.js"></script>
<!-- iCheck -->
<script src="assets/js/icheck.js"></script>
<script>
    function habsubmit() {
        if(($("#campo_email").html() == "") && ($("#campo_login").html() == "") && ($("#campo_nome").html() == "")
            && ($("#campo_inputPassword").html() == "") && ($("#campo_inputConfirm").html() == "")){
            $('#cadastrar').removeAttr('disabled');
        }
    }
            // Variável que receberá o objeto XMLHttpRequest
//             var req;

 //           function validarDados(campo, valor) {

//                 // Verificar o Browser
//                // Firefox, Google Chrome, Safari e outros
//                if(window.XMLHttpRequest) {
//                    req = new XMLHttpRequest();
//                }
//                // Internet Explorer
//                else if(window.ActiveXObject) {
//                    req = new ActiveXObject("Microsoft.XMLHTTP");
//                }
//
//                 // Aqui vai o valor e o nome do campo que pediu a requisição.
//                if (campo == "email") {
//                    var url = "validaEmail.php?campo="+campo+"&valor="+valor;
//                }else if(campo == "login"){
//                     var url = "validaLogin.php?campo="+campo+"&valor="+valor;
//                }
//
//                // Chamada do método open para processar a requisição
//                    req.open("Get", url, true);
//
//
//                    // Quando o objeto recebe o retorno, chamamos a seguinte função;
//                    req.onreadystatechange = function () {
//
//                        // Exibe a mensagem "Verificando" enquanto carrega
//                        if (req.readyState == 1) {
//                            document.getElementById('campo_' + campo + '').innerHTML = '<font color="gray">Verificando...</font>';
//                        }
//
//                        // Verifica se o Ajax realizou todas as operações corretamente (essencial)
//                        if (req.readyState == 4 && req.status == 200) {
//                            // Resposta retornada pelo validacao.php
//                            var resposta = req.responseText;
//
//                            // Abaixo colocamos a resposta na div do campo que fez a requisição
//                            document.getElementById('campo_' + campo + '').innerHTML = resposta;
//                            if(resposta != ""){
//                                $("#cadastrar").attr('disabled', 'disabled');
//                            }else {
//                                $('#cadastrar').removeAttr('disabled');
//                            }
//                        }
//
//                    }
//
//                req.send(null);

//            }

            function ConfereCampos(cmp, val) {
                // Validando Campo Nome:
                // â-ã-à-á-ä-ê-é-è-ë-î-í-ì-ï-ô-õ-ó-ò-ö-û-ú-ù-ü
                if (cmp == "nome") {
                    var regex = /^[a-zA-ZãÃáÁàÀêÊéÉèÈíÍìÌôÔõÕóÓòÒúÚùÙûÛçÇ ]+$/;
                    if (val == "") {
                        $("#campo_nome").html("Preencha o campo com seu Nome!");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if (val.length <= 2) {
                        $("#campo_nome").html("O Nome deve ter no minímo 3 caracteres");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if (!val.match(regex)) {
                        $("#campo_nome").html("Caracteres inválidos no Nome!");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else {
                        $("#campo_nome").html("");
                        habsubmit();
                    }
                } else
                // Fim Campo Nome;
                // Validando Campo Senha:
                if (cmp == "inputPassword") {
                    var confirma = document.getElementById('inputConfirm').value;
                    if (val == "") {
                        $("#campo_inputPassword").html("Preencha o campo com sua Senha!");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if (val.length < 6) {
                        $("#campo_inputPassword").html("A senha deve ter no minímo 6 caracteres");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if ((confirma != "") && (val != confirma)) {
                        $("#campo_inputConfirm").html("As senhas devem ser iguais!");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if ((confirma != "") && (val == confirma)) {
                        $("#campo_inputConfirm").html("");
                        $("#campo_inputPassword").html("");
                    } else {
                        $("#campo_inputPassword").html("");
                        habsubmit();
                    }
                } else
                // Fim Campo Senha;
                // Validando Campo ConfimaSenha:
                if (cmp == "inputConfirm") {
                    var senha = document.getElementById('inputPassword').value;
                    if (val == "") {
                        $("#campo_inputConfirm").html("Digite a senha novamente!");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if (val.length < 5) {
                        $("#campo_inputConfirm").html("A senha deve ter no minímo 6 caracteres");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else if (val != senha) {
                        $("#campo_inputConfirm").html("As senhas devem ser iguais!");
                        $("#cadastrar").attr('disabled', 'disabled');
                    } else {
                        $("#campo_inputConfirm").html("");
                        senha = "";
                        habsubmit();
                    }
                } else
                // Fim Campo Confirma Senha;
                // Validando Campo Login e Email;
                    if((cmp == "login") || (cmp == "email")){
                    var req;
                    // Verificar o Browser
                    // Firefox, Google Chrome, Safari e outros
                    if(window.XMLHttpRequest) {
                        req = new XMLHttpRequest();
                    }
                    // Internet Explorer
                    else if(window.ActiveXObject) {
                        req = new ActiveXObject("Microsoft.XMLHTTP");
                    }

                    // Aqui vai o valor e o nome do campo que pediu a requisição.
                    if (cmp == "email") {
                        var url = "validaEmail.php?campo="+cmp+"&valor="+val;
                    }else if(cmp == "login"){
                        var url = "validaLogin.php?campo="+cmp+"&valor="+val;
                    }

                    // Chamada do método open para processar a requisição
                    req.open("Get", url, true);


                    // Quando o objeto recebe o retorno, chamamos a seguinte função;
                    req.onreadystatechange = function () {

                        // Exibe a mensagem "Verificando" enquanto carrega
                        if (req.readyState == 1) {
                            document.getElementById('campo_' + cmp + '').innerHTML = '<font color="gray">Verificando...</font>';
                        }

                        // Verifica se o Ajax realizou todas as operações corretamente (essencial)
                        if (req.readyState == 4 && req.status == 200) {
                            // Resposta retornada pelo validacao.php
                            var resposta = req.responseText;

                            // Abaixo colocamos a resposta na div do campo que fez a requisição
                            document.getElementById('campo_' + cmp + '').innerHTML = resposta;
                            if(resposta != ""){
                                $("#cadastrar").attr('disabled', 'disabled');
                            }else{
                            habsubmit();
                            }
                        }

                    }

                    req.send(null);
                }
            }

            $("#formCadastrarse").submit(function() {
//                if ($("#campo_nome").html() != ""){
//                    $("#nome").onfocus;
//                }
                $.ajax({
                    type : $("#formCadastrarse").attr('method'),
                    url : $("#formCadastrarse").attr('action'),
                    data : $('#formCadastrarse').serialize(),
                    success: function (data) {
                        console.log(data);
                        swal({
                            title: "Salvo!",
                            text: "Cadastro realizado com sucesso.",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#4682B4",
                            confirmButtonText: "Ok",
                            closeOnConfirm: true
                        }, function () {
                            window.open("login.php", "_parent");
                        });
                    },
                    error : function() {
                        swal("Oops!", "Houve um erro ao salvar o cadastro.", "error");
                    },
                });
                return false;
            });

//        $("#login").on('blur', function(){
//
//            var vl = $(this).val();
//            $.ajax({
//                url: 'validaLogin.php',
//                type: 'POST',
//                data: 'login='+vl,
//                beforeSend: function () {
//                    //$("#btnEnvDados").hide();
//                },
//                success: function (data) {
//                    var ret = $.trim(data);
//                    console.log(data);
//                    if (ret == "OK"){
//                        $("#retorno").html('OK');
//                        //$("#retorno").parent().addClass('has-success');
//                        //$("#retorno").parent().removeClass('has-error has-danger');
//                        //$("#retorno").parent().removeClass('has-danger has-error');
//                        $("#span_login").removeClass('glyphicon-error glyphicon-user');
//                        $("#span_login").addClass('has-success glyphicon-ok');
//                    } else {
//                        $("#retorno").html('Login já Cadastrado!');
//                        $("#retorno").parent().addClass('has-error has-danger');
//                        $("#retorno").parent().removeClass('has-success');
//                        //$("#retorno").parent().addClass('has-danger has-error');
//                        $("#span_login").addClass('glyphicon-error');
//                        $("#span_login").removeClass('glyphicon-ok glyphicon-user');
//                        //$("#nome").removeClass('glyphicon-ok glyphicon-user');
//                    }
//                }
//            });
//        });
    window.onload=function(){
        for(var i=1;i<=31;i++)
            formCadastrarse.dia.options.add(
                new Option(i,i)
            );
        for(var i=1;i<=12;i++)
            if(i == 1){
                formCadastrarse.mes.options.add(
                    new Option('Janeiro',i));
            } else if(i == 2){
                formCadastrarse.mes.options.add(
                    new Option('Fevereiro',i));
            } else if(i == 3){
                formCadastrarse.mes.options.add(
                    new Option('Março',i));
            } else if(i == 4){
                formCadastrarse.mes.options.add(
                    new Option('Abril',i));
            } else if(i == 5){
                formCadastrarse.mes.options.add(
                    new Option('Maio',i));
            } else if(i == 6){
                formCadastrarse.mes.options.add(
                    new Option('Junho',i));
            } else if(i == 7){
                formCadastrarse.mes.options.add(
                    new Option('Julho',i));
            } else if(i == 8){
                formCadastrarse.mes.options.add(
                    new Option('Agosto',i));
            } else if(i == 9){
                formCadastrarse.mes.options.add(
                    new Option('Setembro',i));
            } else if(i == 10){
                formCadastrarse.mes.options.add(
                    new Option('Outubro',i));
            } else if(i == 11){
                formCadastrarse.mes.options.add(
                    new Option('Novembro',i));
            } else if(i == 12){
                formCadastrarse.mes.options.add(
                    new Option('Dezembro',i));
            }

        for(var i=1900;i<=2100;i++)
            formCadastrarse.ano.options.add(
                new Option(i,i)
            );

        formCadastrarse.dia.options[-1+(new Date()).getDate()].selected="selected";
        formCadastrarse.mes.options[(new Date()).getMonth()].selected="selected";
        formCadastrarse.ano.options[(new Date()).getYear()].selected="selected";

        formCadastrarse.dia.onblur=salva;
        formCadastrarse.mes.onblur=salva;
        formCadastrarse.ano.onblur=salva;

    };

    var sucesso=function(){
        campo_datanasc.innerHTML=null;
        habsubmit();
    };
    var erro=function(){
        campo_datanasc.innerHTML="Data de Nascimento Inválida";
        $("#cadastrar").attr('disabled', 'disabled');
    };

    var salva=function(){
        var dia=parseInt(formCadastrarse.dia.value),
            mes=parseInt(formCadastrarse.mes.value),
            ano=parseInt(formCadastrarse.ano.value);

        if(dia==31&&[1,3,5,7,8,10,12].indexOf(mes)==-1)
            return erro();
        if(dia==30&&mes==2)
            return erro();
        if(dia==29&&mes==2&&ano%4!=0)
            return erro();
        return sucesso();
    };
</script>
<script src="assets/css/SweetAlert/sweetalert.min.js"></script>
</body>
</html>
