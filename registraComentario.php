<?php
session_start();
if(!isset($_SESSION['login'])){
    header('Location: profile.php');
}
    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    $objdb = new db();
    $link = $objdb->conecta_mysql();

    $idDocente = $_SESSION['id'];
    $idAula = $_GET['idAula'];
    if (isset($_GET['textComentario']) && $_GET['textComentario']<>''){
        $textoComentario = addslashes($_GET['textComentario']);
        $sqlInsertComentarios = "INSERT INTO comentario (ID, DATACOMENTARIO, DESCRICAO, IDDOCENTE)
                                 VALUES (null, '".retDataHora()."', '$textoComentario',$idDocente)";
        try{
            $insert = mysqli_query($link, $sqlInsertComentarios);
            if($insert){
                if($idDocente <> retDocenteAula($idAula)){
                    header("Location: verAula.php?idAula=".$idAula."");
                }else{
                    header("Location: docenteVisaoAula.php?idAula=".$idAula."");
                }
            }
        }catch (Exception $e){
            echo "Problema para registrar o comentário...: ".$e->getMessage();
        }

        if ($insert){
            $ultimoComent = mysqli_query($link, "select last_insert_id() as lastId from comentario limit 1");
            if($ultimoComent){
                while ($dadosComentario = mysqli_fetch_array($ultimoComent, MYSQLI_ASSOC)){
                    $idUltimoComentario = $dadosComentario['lastId'];
                    echo "<br/>";
                    echo "ultimo idComentario > ".$idUltimoComentario;

                    $sqlInsertAulaComentarios = "insert into aulacomentarios(id, idaula, idcomentario)
                                             values (null, $idAula,$idUltimoComentario)";

                    echo $sqlInsertAulaComentarios;
                    echo '<br/>';

                    $aulaComent = mysqli_query($link, $sqlInsertAulaComentarios);

                    if($aulaComent){

                        //nesse ponto, é necessário criar as notificações.

                    }else{
                        echo "nao gravou";
                    }
                }
            }

        }else{
            echo "Erro ao recuperar último comentário inserido.";
        }
    }else{
        exit;
    }
?>