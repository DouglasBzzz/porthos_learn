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

            if(is_dir('./FOTOS/'.$idDocente.'/')){
                $diretorio_upload = ('./FOTOS/'.$idDocente.'/');
            }else {
                mkdir('./FOTOS/'.$idDocente.'/');
                $diretorio_upload = ('./FOTOS/'.$idDocente.'/');
            }

            header('Location: profile.php');

            if((isset($_FILES['imgUser']['name'])) && ($_FILES['imgUser']['name']) <> ''){
                //$extensao = strtolower(end(explode('.',$_FILES['imgUser']['name'])));
                //if(!array_search($extensao, $arq['extensoes'])===false){

                        $_FILES['imgUser']['name'] = 'profile';
                        $nomeArquivo = $_FILES['imgUser']['name'];

                        //$nomeArquivo = rename($_FILES['imgUser']['name'],'profile.png');
                        //$nomeArquivo = $idDocente.retDataHora();
                        $tipoArquivo = $_FILES['imgUser']['type'];
                        $tamanhoArquivo = $_FILES['imgUser']['size'];

                        $arquivo_upload = $diretorio_upload . basename($_FILES['imgUser']['name']);

                        unlinkRecursive($diretorio_upload,false);

                        if (move_uploaded_file($_FILES['imgUser']['tmp_name'], $arquivo_upload)) {

                            //unlinkRecursive($diretorio_upload,false);

                            //$FOTO = $diretorio_upload.$_FILES['imgUser']['name'];
                            $FOTO = $diretorio_upload.$nomeArquivo;


                            echo "CRIAR PASTA PARA fota - > OK<br />";
                            echo '<br/>';

                            $sqlFoto = "update docente set foto = '$FOTO' where id = $idDocente";
                            if($caminhoFoto = mysqli_query($link, $sqlFoto)){
                                echo 'deu boa no banco...<br/>';
                            }else{
                                echo 'deu ruim no banco...';
                            }

                        } else {
                            echo "CRIAR PASTA PARA fots - > NAO CRIOU<br />";
                        }

                //}else{echo '<br/>mande somente arquivos em extensao valida...<br/>';}
            }else{echo '<br/>o nome do arquivo nao eh valido...<br/>';}
