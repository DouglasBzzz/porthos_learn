<?php

    session_start();

    require_once('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');


    if(isset($_POST['title'])&&$_POST['title']<>''){
        $title = addslashes($_POST['title']);
    }
    if(isset($_POST['editor1'])&&$_POST['editor1']<>''){
        $descricao = addslashes($_POST['editor1']);
    }
    if(isset($_POST['descConteudo'])&&$_POST['descConteudo']<>''){
        $descAula = addslashes($_POST['descConteudo']);
    }
    if(isset($_POST['listInteresses'])&&$_POST['listInteresses']<>''){
        $listaDeInteresses = $_POST['listInteresses'];
    }
    if(isset($_POST['faixaEtaria'])&&$_POST['faixaEtaria']<>''){
        $faixaEtaria = $_POST['faixaEtaria'];
    }
    if(isset($_POST['tipoAula'])&&$_POST['tipoAula']<>''){
        $tipoAula = $_POST['tipoAula'];
    }
    if(isset($_POST['nAlunosIdeal'])&&$_POST['nAlunosIdeal']<>''){
        $nAlunos = $_POST['nAlunosIdeal'];
    }
    if(isset($_POST['linkAtvWeb'])&&$_POST['linkAtvWeb']<>''){
        $linkWeb = addslashes($_POST['linkAtvWeb']);
    }else{
        $linkWeb = null;
    }
    if(isset($_POST['publica'])&&$_POST['publica']<>''){
        $publica = $_POST['publica'];
    }
    $idUsuarioSessao = $_SESSION['id'];

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = "INSERT INTO aula (title, descconteudo, idfaixaetariarecomendada, iddocente, idtipoaula, nalunosideal,
                    linkweb, descricao, datainclusao, publica) values ('$title','$descAula', $faixaEtaria, $idUsuarioSessao,
                    $tipoAula,$nAlunos,'$linkWeb','$descricao','".retDataHora()."',$publica)";

    /*$sql = "insert into aula(title, descconteudo, idfaixaetariarecomendada, iddocente, idtipoaula, nalunosideal, linkweb,
                             descricao, datainclusao, publica) values ('Teste do Douglas inclusão manual','Esse é um teste na unha',
                                                                       2,107,3,10,'','VEJAMOS SE ASSIM VAI',now(),1)";*/

    try{

        $insereAula = mysqli_query($link, $sql);

    }catch (Exception $e){
        echo "erro: ".$e->getMessage();
        //exit;
    }

    if ($insereAula) {
        //echo 'CRIAR REGISTRO EM AULA - > OK <br/>';
        header('Location: profile.php');
    } else {
        echo 'CRIAR REGISTRO EM AULA - > NAO GRAVOU <br/>';
        echo 'Código do Erro..: '.mysqli_errno($link);
        echo '</br>';
        echo $sql;
        exit;
        //echo $sql;
    }

    $sqlInteresses = "insert into aulainteresses values ";
    foreach ($listaDeInteresses as $interesse) {
        $idInteresse = $interesse;
        $sqlInteresses .= "(null,(select id from aula where iddocente = '$idUsuarioSessao' order by id desc limit 1), '{$idInteresse}'),";
    }

    $sqlInteresses = substr($sqlInteresses, 0, -1);

    if (mysqli_query($link, $sqlInteresses)) {
        echo 'CRIAR REGISTRO EM AULAINTERESSES - > OK';
        echo '<br/>';
    } else {
        echo 'CRIAR REGISTRO EM AULAINTERESSES - > NAO GRAVOU';
        echo '</br>';
    }
        //echo $sqlInteresses;

        //comeca a gravar os arquivos da aula

        $sqlIdUltimaAula = "select convert(id, char(11)) as aulaid
                            from aula 
                            where iddocente = $idUsuarioSessao and title = '$title' order by id desc limit 1";

        $aulaID = mysqli_query($link,$sqlIdUltimaAula);

        if($aulaID){
            $identificadorAula = mysqli_fetch_array($aulaID);

            if (isset($identificadorAula['aulaid'])){

                $notificao = new functions();
                $notificao ->criaNotificacaoAula($idUsuarioSessao,$title);

                $total_arquivos = count($_FILES['arquivos']['name']);

                mkdir('./AULAS/'."$identificadorAula[aulaid]".'/');
                $diretorio_upload = ('./AULAS/'."$identificadorAula[aulaid]".'/');

                for ($i=0; $i < $total_arquivos; $i++) {

                    if((isset($_FILES['arquivos']['name'][$i])) && ($_FILES['arquivos']['name'][$i]) <> ''){
                                $nomeArquivo = $_FILES['arquivos']['name'][$i];
                                $tipoArquivo = $_FILES['arquivos']['type'][$i];
                                $tamanhoArquivo = $_FILES['arquivos']['size'][$i];

                                $sqlArquivos = "insert into arquivo(id, descricao, datacriacao,tipo,tamanho,idaula,path) 
                                                                   values(null, '$nomeArquivo', '".retDataHora()."', '$tipoArquivo',
                                                                   '$tamanhoArquivo',$identificadorAula[aulaid]+0,'$diretorio_upload')";

                                if(mysqli_query($link, $sqlArquivos)){
                                    echo 'GRAVAR REGISTRO NO BANCO - > OK';
                                    echo '<br/>';
                                }else{
                                    echo '</br>GRAVAR REGISTRO NO BANCO - > NAO GRAVOU<br/>';
                                };

                                $arquivo_upload = $diretorio_upload . basename($_FILES['arquivos']['name'][$i]);

                                if (move_uploaded_file($_FILES['arquivos']['tmp_name'][$i], $arquivo_upload)) {

                                    echo "CRIAR PASTA PARA OS ARQUIVOS DA AULA - > OK<br />";
                                    echo '<br/>';
                                } else {
                                    echo "CRIAR PASTA PARA OS ARQUIVOS DA AULA - > NAO CRIOU<br />";
                                }

                        //}else{echo '<br/>mande somente arquivos em extensao valida...<br/>';}
                    }else{echo '<br/>o nome do arquivo nao eh valido...<br/>';}
                }
            }
        }

//header('Location: profile.php');

?>
