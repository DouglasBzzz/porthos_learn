<?php
    require_once ('db.class.php');
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 30/09/2017
 * Time: 14:26
 */

    function retDataHora(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select date_add(now(), interval -3 hour) as nData, now() as oData";

        if($dateTime = mysqli_query($link, $sql)){
            $ret = mysqli_fetch_array($dateTime);
        }

        if(isset($ret['nData'])&&$ret['nData']<>$ret['oData']){
            $data = $ret['nData'];
        }else{
            $data = $ret['oData'];
        }

        return $data;
    }

    function unlinkRecursive($dir, $deleteRootToo)
    {
        if(!$dh = @opendir($dir))
        {
            return;
        }
        while (false !== ($obj = readdir($dh)))
        {
            if($obj == '.' || $obj == '..')
            {
                continue;
            }

            if (!@unlink($dir . '/' . $obj))
            {
                unlinkRecursive($dir.'/'.$obj, true);
            }
        }
        closedir($dh);
        if ($deleteRootToo)
        {
            @rmdir($dir);
        }
        return;
    }

    function retFoto($docenteId){
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "select d.id, cast(d.foto as char(255)) as caminhoFoto
                    from docente as d
                    where d.id = $docenteId";

    if($carregaCaminho = mysqli_query($link, $sql)) {
        $caminhoFotoPerfil = mysqli_fetch_array($carregaCaminho);

        //$caminho = $caminhoFotoPerfil['caminhoFoto'];
        $idDocente = $caminhoFotoPerfil['id'];
        $caminho = './FOTOS/'."$idDocente";
        $dir = opendir($caminho);
        while($file = readdir($dir)){
            if ($file != '..' && $file != '.') {
                //echo "<img src='".$caminho."/".$entry."' class='img-circle' alt='User Image'/>";
                return $caminho . "/" . $file;
                //echo  $caminhoFoto;
            } else {
                //return 'assets/imagens/user1-128x128.jpg';
            }
        }
    }
}

    function retCapa($docenteId){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select d.id, cast(d.FOTOCAPA as char(255)) as caminhoFoto
                    from docente as d
                    where d.id = $docenteId";

        if($carregaCaminho = mysqli_query($link, $sql)) {

            $caminhoFotoCapa = mysqli_fetch_array($carregaCaminho);
            $idDocente = $caminhoFotoCapa['id'];
            $caminho = './CAPA/'."$idDocente";

            $dir = opendir($caminho);
            while($file = readdir($dir)){
                if ($file != '..' && $file != '.') {
                    //echo "<img src='".$caminho."/".$entry."' class='img-circle' alt='User Image'/>";
                    return $caminho . "/" . $file;
                    //echo  $caminhoFoto;
                } else {
                    //return 'assets/imagens/user1-128x128.jpg';
                }
            }

        }
    }

    function logOut(){

        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $docente = $_SESSION['id'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $sqlLogOut = "update logacesso set datalogout = '".retDataHora()."' 
              where iddocente = $docente and ip = '$ip'";

        mysqli_query($link,$sqlLogOut);

        unset($_SESSION['usuario']);
        unset($_SESSION['email']);

        header('Location: index.php');
        session_destroy();
    }

    function retDocenteAula($idAula){
        $objDb = new db();
        $link = $objDb ->conecta_mysql();

        $sql="select iddocente from aula where id = $idAula";

        if($result = mysqli_query($link, $sql)){
            $docenteId = mysqli_fetch_array($result);
            return $docenteId['iddocente'];
        }
    }

    function email($assunto, $endereco, $mensagem){
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
            $mail -> CharSet = 'UTF-8';

            //Define o remetente
            // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            $mail->SetFrom('contato@porthoslearn.com.br', 'Contato - Porthos Learn'); //Seu e-mail
            $mail->AddReplyTo('douglas@porthoslearn.com.br', 'Douglas - Porthos Learn'); //Seu e-mail
            //$mail->Subject = 'Contato';//Assunto do e-mail
            $mail ->Subject = $assunto;


            //Define os destinatário(s)
            //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            //$mail->AddAddress('d.bianchezzi@gmail.com', 'Teste zoho');
            $mail -> AddAddress($endereco, 'Contato - Porthos');

            //Campos abaixo são opcionais
            //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
            //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
            //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
            //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo


            //Define o corpo do email
            //$mail->MsgHTML('corpo do email');
            $mail ->MsgHTML($mensagem);

            ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
            //$mail->MsgHTML(file_get_contents('arquivo.html'));

            $mail->Send();
            //echo "Mensagem enviada com sucesso</p>\n";

            //caso apresente algum erro é apresentado abaixo com essa exceção.
        }catch (phpmailerException $e) {
            echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
        }
    }

    function logLearn($mensagem, $rotina, $acao){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "insert into log(id,mensagem,dataRegistro,acao) values (null, '[LOG]: $mensagem --$rotina',now(),'$acao')";
        try{
            mysqli_query($link,$sql);
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    function gravaPesquisa($usuario, $busca){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "insert into logbusca(id, valorBusca, iddocente, datapesquisa) values (null,'$busca',$usuario,now())";

        if($gravaLog = mysqli_query($link, $sql)){
            //echo 'ok';
        }else{
            //echo 'nao ok';
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function retEmailDocente($docenteId){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select d.email
                from docente as d
                where d.id = $docenteId";
        try{
            $resultConsulta = mysqli_query($link,$sql);
            if($resultConsulta){
                while($email = mysqli_fetch_array($resultConsulta, MYSQLI_ASSOC)){
                    return $email['email'];
                }
            }
        }catch (Exception $e){
            echo "Ouve um erro para retornar o E-mail do docente...: ".$e->getMessage();
        }


    }

?>