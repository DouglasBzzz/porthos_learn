<?php

session_start();

if(!isset($_SESSION['id'])){
    header('Location: index.php?erro=1');
}

require_once('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');

$idDocente = $_SESSION['id'];
$idSeguido = $_POST['idSeguidoNao'];

if($idDocente == '' || $idSeguido == ''){
    die();
}

$objDb = new db();
$link = $objDb->conecta_mysql();

$sqlDeixarDeSeguir = "update seguidores set datadeixoudeseguir = '".retDataHora()."'
                      where idseguido = $idSeguido and idseguidor = $idDocente";

mysqli_query($link, $sqlDeixarDeSeguir);

$sqlDeixarDeSeguir2 = "update seguidores set seguindo = 0 
                      where IDSEGUIDO = $idSeguido and IDSEGUIDOR = $idDocente";

mysqli_query($link, $sqlDeixarDeSeguir2);

$sqlDeletaSeguidor = "delete from seguidores where IDSEGUIDO = $idSeguido and IDSEGUIDOR = $idDocente";
mysqli_query($link, $sqlDeletaSeguidor);

//echo $sqlSeduidores;

?>