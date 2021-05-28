<?php 
	
	session_start();

	require_once('db.class.php');
	include ('nFuncoes.php');

	$login = addslashes($_POST['login']);
	$senha = md5($_POST['senha']);
	//$email = $_POST['email'];

	$sql = "select id, nome, login, senha, email, situacao, genero, datacadastro 
            from docente where (login = '$login' or email = '$login') AND 
              senha = '$senha' AND situacao = 1";

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){
		$dados_usuario = mysqli_fetch_array($resultado_id);

		if(isset($dados_usuario['login'])){

			$_SESSION['id'] = $dados_usuario['id'];
			$_SESSION['login'] = $dados_usuario['login'];
			$_SESSION['nome'] = $dados_usuario['nome'];
			//$_SESSION['email'] = $dados_usuario['email'];

            $ipUsuario = $_SERVER['REMOTE_ADDR'];

			header('Location: profile.php');

			$sqlLogAcesso = "insert into logacesso(id, DATALOGIN,IDDOCENTE, ip) 
                             values (null, '".retDataHora()."', $_SESSION[id], '$ipUsuario')";

			mysqli_query($link, $sqlLogAcesso);

		} else {
			header('Location: login.php?erro=1');
		}
	} else {
		echo 'Erro na execução da consulta, favor entrar em contato com o admin do site';
	}

?>