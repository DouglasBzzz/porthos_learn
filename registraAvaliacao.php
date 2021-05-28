<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 29/08/2017
 * Time: 22:37
 */

session_start();
require_once ('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');

$objDb = new db();
$link = $objDb ->conecta_mysql();

$idDocente = $_SESSION['id'];
$idAula = $_GET['idAula'];
if(isset($_GET['avaliacao'])){
    $valorAvaliacao = $_GET['avaliacao'];
}else{
    $valorAvaliacao = 0;
}

$sqlInsertAvaliacao = "insert into avaliacao(id, nota, DATAAVALIACAO, IDDOCENTE, IDAULA)
                       VALUES (null, $valorAvaliacao, '".retDataHora()."', $idDocente, $idAula)";

$insereAvaliacao = mysqli_query($link, $sqlInsertAvaliacao);

if($insereAvaliacao){
    header("Location: verAula.php?idAula=".$idAula."");
}else{
    echo 'deu ruim pra incluir a avaliacao... <br/>';
}

?>