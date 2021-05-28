<?php


    // Inclui o arquivo class.phpmailer.php localizado na pasta class
    require_once("class/class.phpmailer.php");

    // Inicia a classe PHPMailer
    $mail = new PHPMailer(true);

    // Define os dados do servidor e tipo de conexão
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsSMTP(); // Define que a mensagem será SMTP

    try {
        $mail->Host = 'smtp.zoho.com'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
        $mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
        $mail->Port       = 465; //  Usar 587 porta SMTP
        $mail->Username = 'contato@porthoslearn.com.br'; // Usuário do servidor SMTP (endereço de email)
        $mail->Password = 'P0rth0s3#'; // Senha do servidor SMTP (senha do email usado)
        $mail->SMTPSecure = 'ssl';

        //Define o remetente
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->SetFrom('contato@porthoslearn.com.br', 'Contato - Porthos Learn'); //Seu e-mail
        $mail->AddReplyTo('douglas@porthoslearn.com.br', 'Contato - Porthos Learn'); //Seu e-mail
        $mail->Subject = 'Contato';//Assunto do e-mail


        //Define os destinatário(s)
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $mail->AddAddress('d.bianchezzi@gmail.com', 'Teste zoho');

        //Campos abaixo são opcionais
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
        //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
        //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


        //Define o corpo do email
        $mail->MsgHTML('corpo do email');

        ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
        //$mail->MsgHTML(file_get_contents('arquivo.html'));

        $mail->Send();
        echo "Mensagem enviada com sucesso</p>\n";

        //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
        echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
    }

    echo 'cheguei ao fim...';
?>