<?php

	session_start();

	if(!isset($_SESSION['id'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');
	include ('nFuncoes.php');
	include ('functions.php');

	//id's
	$idDocente = $_SESSION['id'];
	$idSeguido = $_POST['idSeguido'];
	// nomes
	$nomeSeguido = new functions();
	$nomeSeguido -> retNomeDocente($idSeguido);
	$nomeSeguidor = new functions();
	$nomeSeguidor ->retNomeDocente($idDocente);

	if($idDocente == '' || $idSeguido == ''){
		die();
	}

	$objDb = new db();
	$link = $objDb->conecta_mysql();

    $sqlSeduidores = "INSERT INTO seguidores values(null, '".retDataHora()."',null,$idSeguido,$idDocente,1)";

    try{
        $instrucao = mysqli_query($link, $sqlSeduidores);
        if ($instrucao){
            $sqlNotificacao = "select d.recebenotificacao
                                       from docente as d
                                       where d.id=$idSeguido";
            try{
               $notificacao = mysqli_query($link,$sqlNotificacao);
               if ($notificacao){
                   $recebeNotificacao = mysqli_fetch_array($notificacao, MYSQLI_ASSOC);
                   if(($recebeNotificacao['recebenotificacao'])==1){
                       email("Contato - Porthos",retEmailDocente($idSeguido),"
                                            Olá! você tem um novo seguidor no <a href = 'www.porthoslearn.com.br'>Learn!<a/>
                                            ");
                   }
               }
            }catch (Exception $e){
                echo "Ouve um problema para verificar as notificações do Docente Seguido...: ".$e->getMessage();
            }
        }
    }catch (Exception $e){
        echo "Ouve um erro para executar a instrução...: ".$e->getMessage();
    }
?>