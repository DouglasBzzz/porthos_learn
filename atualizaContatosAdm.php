<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 23/09/2017
 * Time: 15:42
 */
    require_once ('db.class.php');
    require_once('funcoesAdm.php');

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $idContato = $_POST['idContato'];
    if(isset($_POST['ckStatus'])){

        $situacao = 1;
        $sql = "update contato set status = $situacao 
                where id = $idContato";
    }

    if($atualiza = mysqli_query($link, $sql)){
        header('Location: contatosAdm.php');
    }else{
        echo 'nao deu certo';
    }
?>