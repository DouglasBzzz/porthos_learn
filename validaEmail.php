<?php
require_once('db.class.php');

// Campo que fez requisição
$campo = $_GET['campo'];
// Valor do campo que fez requisição
$valor = $_GET['valor'];

function isMail($valor){
    $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
    if (preg_match($er, $valor)){
        return true;
    } else {
        return false;
    }
}

$objDb = new db();
$link = $objDb->conecta_mysql();

$sqlLogin = "select EMAIL from docente where email  = '$valor'";
if($resultadoId = mysqli_query($link, $sqlLogin)){
    $dadosDocente = mysqli_fetch_array($resultadoId);
    $login = $dadosDocente['EMAIL'];
       if ($campo == "email") { // Verificando o campo email
           if ($valor == "") {
               echo "Preencha o campo com seu E-mail!";
           } elseif (!isMail($valor)) {
               echo "E-mail Inválido!!";
           } elseif (isset($dadosDocente['EMAIL'])) {
               echo "E-mail já Cadastrado!!";
           }
       }
}
die();
?>