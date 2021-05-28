<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 03/09/2017
 * Time: 09:51
 */

    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: profile.php');
    }

    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    $objdb = new db();
    $link = $objdb->conecta_mysql();

    $docenteId = $_SESSION['id'];
    $title = addslashes($_POST['title']);
    $comment = addslashes($_POST['txtComentario']);

    $sqlInsertComentario = "insert into contato VALUES (null, '$title', '$comment','".retDataHora()."',$docenteId,0)";

    $insereSql = mysqli_query($link,$sqlInsertComentario);

    if($insereSql){
        header('Location: profile.php');
        /*$sqlUltimoContato = "select convert(id, char(11)) as contatoId
                             from contato 
                             where IDDOCENTE = $docenteId and title = '$title' order by id desc limit 1";

        $contatoId = mysqli_query($link,$sqlUltimoContato);

        if($contatoId){
            $identificadorContato = mysqli_fetch_array($contatoId);

            if(isset($identificadorContato['contatoId'])){

                $total_arquivos = count($_FILES['anexos']['name']);

                mkdir('./CONTATOS/'."$identificadorContato[contatoId]".'/');
                $diretorio_upload = ('./CONTATOS/'."$identificadorContato[contatoId]".'/');

                for ($i=0; $i < $total_arquivos; $i++) {

                    if((isset($_FILES['anexos']['name'][$i])) && ($_FILES['anexos']['name'][$i]) <> ''){
                        $extensao = strtolower(end(explode('.',$_FILES['anexos']['name'][$i])));
                        if(!array_search($extensao, $arq['extensoes'])===false){
                            $nomeArquivo = utf8_encode($_FILES['anexos']['name'][$i]);
                            $tipoArquivo = $_FILES['anexos']['type'][$i];
                            $tamanhoArquivo = $_FILES['anexos']['size'][$i];


                            echo $nomeArquivo;
                            echo '<br/>';
                            echo $tipoArquivo ;
                            echo '<br/>';
                            echo $tamanhoArquivo ;

                            $sqlArquivos = "insert into arquivo(id, descricao, datacriacao,tipo,tamanho,idcontato,path)
                                            values(null, '$nomeArquivo', now(), '$tipoArquivo','$tamanhoArquivo',$identificadorContato[contatoId]+0,'$diretorio_upload')";

                            if(mysqli_query($link, $sqlArquivos)){
                                echo '<br/>GRAVAR REGISTRO NO BANCO - > OK';
                                echo '<br/>';
                            }else{
                                echo '</br>GRAVAR REGISTRO NO BANCO - > NAO GRAVOU<br/>';
                            };

                            $arquivo_upload = $diretorio_upload . basename($_FILES['anexos']['name'][$i]);

                            if (move_uploaded_file($_FILES['anexos']['tmp_name'][$i], $arquivo_upload)) {

                                echo "CRIAR PASTA PARA OS ARQUIVOS DO CONTATO - > OK<br />";
                                echo '<br/>';
                            } else {
                                echo "CRIAR PASTA PARA OS ARQUIVOS DO CONTATO - > NAO CRIOU<br />";
                            }

                        }else{echo '<br/>mande somente arquivos em extensao valida...<br/>';}
                    }else{echo '<br/>o nome do arquivo nao eh valido...<br/>';}

                }
            }
        }*/
    }else{
        echo 'Tivemos problemas para gravar seu contato. Por favor, entre em contato pelo e-mail: porthos@porthos.com.br';
    }
    /*if($insereSql){
        header('Location: profile.php');
    }else{
        echo 'Infelizmente seu comentário não foi processado! Por favor, entre em contato com o adm do da aplicação pelo e-mail...: ';
    }*/
    //echo $title;

?>