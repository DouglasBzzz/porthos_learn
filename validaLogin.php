<?php
	require_once('db.class.php');

	//$login = $_POST['login'];
    // Campo que fez requisição
    $campo = $_GET['campo'];
    // Valor do campo que fez requisição
    $valor = $_GET['valor'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sqlLogin = "select LOGIN from docente where login  = '$valor'";
	if($resultadoId = mysqli_query($link, $sqlLogin)){
	    $dadosDocente = mysqli_fetch_array($resultadoId);
       $login = $dadosDocente['LOGIN'];
               if ($valor == "") {
                echo "Preencha o campo com seu login!";
               } elseif(isset($dadosDocente['LOGIN'])) {
                   echo "login já Cadastrado!";
                } elseif (strlen($valor) > 25) {
                    echo "O login deve ter no máximo 25 caracteres";
                } elseif (strlen($valor) <= 2) {
                    echo "O login deve ter no minímo 3 caracteres";
                } elseif (!preg_match("/^[a-zA-Z-0-9]+$/", $valor)) { ///^[A-Za-z0-9]+$/
                    echo "O login deve conter apenas letras e numeros.";
                }
            }
    die();
?>