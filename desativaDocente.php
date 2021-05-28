<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 20/10/2017
 * Time: 19:59
 */

    session_start();

    require_once('db.class.php');
    include('nFuncoes.php');

    //picollo, só descomenta o que ta comentado, quando descobrir o que diabos acontece que nao manda pra outra pagina...
    //$usuario = 86; //comentar esse quando o de baixo funcionar.
    $usuario = $_POST['idUsarioSessao'];

    //echo $usuario;

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $data = retDataHora();

    $sql = "update docente set datadesativacao = '$data' where id =$usuario;";
    $sql2 = "update docente set situacao = 0 where id = $usuario";
    $sql3 = "update docente set nome = concat(nome, ' (INATIVO)') where id = $usuario";


    //echo $sql;
    try{
        mysqli_query($link, $sql);
        mysqli_query($link, $sql2);
        mysqli_query($link, $sql3);
        logOut();
    }catch (Exception $e){
        echo 'erro...:',$e->getMessage();
    }
        //logOut();

?>