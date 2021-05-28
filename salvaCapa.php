<?php

    session_start();

    require_once('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    //arquivos
    //$arq['extensoes'] = array('jpg','png');

    $objDb = new db();
    $link = $objDb->conecta_mysql();
    $nomes = new functions();

        $idDocente = $_SESSION['id'];

            if(is_dir('./CAPA/'.$idDocente.'/')){
                $diretorio_upload = ('./CAPA/'.$idDocente.'/');
            }else {
                mkdir('./CAPA/'.$idDocente.'/');
                $diretorio_upload = ('./CAPA/'.$idDocente.'/');
            }

            header('Location: profile.php');

            if((isset($_FILES['imgCapa']['name'])) && ($_FILES['imgCapa']['name']) <> ''){
                //$extensao = strtolower(end(explode('.',$_FILES['imgCapa']['name'])));
                //if(!array_search($extensao, $arq['extensoes'])===false){
                        //$nomeArquivo = $_FILES['imgCapa']['name'];
                        $_FILES['imgUser']['name'] = 'wallpaper';
                        $nomeArquivo = $_FILES['imgUser']['name'];

                        $tipoArquivo = $_FILES['imgCapa']['type'];
                        $tamanhoArquivo = $_FILES['imgCapa']['size'];

                        $arquivo_upload = $diretorio_upload . basename($_FILES['imgCapa']['name']);

                        unlinkRecursive($diretorio_upload,false);

                        if (move_uploaded_file($_FILES['imgCapa']['tmp_name'], $arquivo_upload)) {

                            $FOTO = $diretorio_upload.$_FILES['imgCapa']['name'];

                            echo "CRIAR PASTA PARA capa - > OK<br />";
                            echo '<br/>';

                            $sqlFoto = "update docente set FOTOCAPA = '$FOTO' where id = $idDocente";
                            if($caminhoFoto = mysqli_query($link, $sqlFoto)){
                                echo 'deu boa no banco...<br/>';
                            }else{
                                echo 'deu ruim no banco...';
                            }

                        } else {
                            echo "CRIAR PASTA PARA capa - > NAO CRIOU<br />";
                        }

                //}else{echo '<br/>mande somente arquivos em extensao valida...<br/>';}
            }else{echo '<br/>o nome do arquivo nao eh valido...<br/>';}
