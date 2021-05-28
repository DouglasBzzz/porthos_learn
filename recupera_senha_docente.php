<?php

    require_once ('db.class.php');
    include ('nFuncoes.php');
    $email = addslashes($_POST['email']);
    //$assunto = "Recuperação de senha - Porthos";
    $objDb = new db();
    $link = $objDb ->conecta_mysql();

    $sender_email = stripslashes($_POST["sender_email"]);
    $sender_message = stripslashes($_POST["sender_message"]);
    $response = $_POST["g-recaptcha-response"];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LfBqC8UAAAAAHXMkf15ceeROeCvH-7qIoXUsfmV',
        'response' => $_POST["g-recaptcha-response"]
    );
    $options = array(
        'http' => array (
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);
    if ($captcha_success->success==false) {
        echo "<p>You are a bot! Go away!</p>";
    } else if ($captcha_success->success==true) {
        //echo "<p>You are not not a bot!</p>";
        try{

            $sql = "select email, id, nome from docente where (email <> '' and email = '$email') and situacao = 1";
            $consulta = mysqli_query($link, $sql);
            if($consulta){

                while($dados = mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
                    $idDocente = $dados['id'];
                    $nomeDocente = $dados['nome'];
                    $senha = generateRandomString();
                    $mensagem = "Olá $nomeDocente, <br/> Sua solicitação de aleração de senha foi efetivada. 
                                                <br/> Sua nova senha é a seguinte: $senha 
                                                <br/> Pedimos que verifique suas credenciais em seu proximo acesso! <br/>
                                                <br>
                                                Abraços, equipe Porthos";

                    if (isset($idDocente)){
                        $sqlTrocaDeSenha = "update docente set senha = '".md5($senha)."' where id = $idDocente;";
                        echo $sqlTrocaDeSenha;
                        $exec = mysqli_query($link, $sqlTrocaDeSenha);
                        if($exec){
                            email("Reset de senha - Porthos",$email,$mensagem);
                        }else{
                            echo "Não foi possível disparar o e-mail com sua senha temporária, entre em contato com a equipe Porthos através do e-mail <contato@porthoslear.com.br>";
                        }
                    }else{
                        echo "Não foi possível disparar o e-mail com sua senha temporária, entre em contato com a equipe Porthos através do e-mail <contato@porthoslear.com.br>";
                    }
                }
            }else{
                echo "Não foi possível disparar o e-mail com sua senha temporária, entre em contato com a equipe Porthos através do e-mail <contato@porthoslear.com.br>";
            }

        }catch (Exception $e){
            echo "Não foi possível disparar o e-mail com sua senha temporária, entre em contato com a equipe Porthos através do e-mail <contato@porthoslear.com.br>";
        }
        header('Location: login.php');
    }

    /*$mensagem = "Teste de conteúdo para disparar no e-mail";
    $endereco = "d.bianchezzi@gmail.com";*/




    //email($assunto,$endereco,$mensagem);
