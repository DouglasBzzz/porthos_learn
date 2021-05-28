<?php 

    //china. validar da mesma forma como o cadastro
   //todo... fazendo retornar direto em tela ... para nao precisar usar o addslashes. byDOUGLAS em 03/08.

	require_once('db.class.php');
	include ('nFuncoes.php');
	$nome = $_POST['nome'];
	$login = $_POST['login'];
	$senha = md5($_POST['inputPassword']);
	$genero = $_POST['genero'];
	$email = $_POST['email'];
	$dia = $_POST['dia'];
    $mesString = $_POST['mes'];
    $mes = "";
    $ano = $_POST['ano'];
//       if ($mesString == "Janeiro"){
//           $mes = "01";
//       }elseif ($mesString == "Fevereiro") {
//           $mes = "02";
//       }elseif ($mesString == "Março") {
//           $mes = "03";
//       }elseif ($mesString == "Abril") {
//           $mes = "04";
//       }elseif ($mesString == "Maio") {
//           $mes = "05";
//       }elseif ($mesString == "Junho") {
//           $mes = "06";
//       }elseif ($mesString == "Julho") {
//           $mes = "07";
//       }elseif ($mesString == "Agosto") {
//           $mes = "08";
//       }elseif ($mesString == "Setembro") {
//           $mes = "09";
//       }elseif ($mesString == "Outubro"){
//           $mes = "10";
//       }elseif ($mesString == "Novembro"){
//           $mes = "11";
//       }elseif ($mesString == "Dezembro"){
//           $mes = "12";
//       }
	//$senha = md5($_POST['senha']);
$dataNasc ="";
$dataNasc = $ano.'-'.$mesString.'-'.$dia.' 00:00:00';
echo $dataNasc;
//'2017-09-16 18:37:39'

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = " INSERT INTO docente(nome,login,senha,situacao,genero,email,datacadastro,datanascimento)VALUES('$nome','$login',
	'$senha',1,'$genero','$email','".retDataHora()."','".$dataNasc."')";
        if(mysqli_query($link, $sql)){
            $sqlDocenteCadastrado = "select last_insert_id(id) as idDocente 
                                     from docente order by id desc limit 1";
            if($docenteCadastrado = mysqli_query($link, $sqlDocenteCadastrado)){
                $docente=mysqli_fetch_array($docenteCadastrado);
                if(isset($docente['idDocente'])){
                    $idDocente = $docente['idDocente'];
                    mkdir('./FOTOS/'.$idDocente.'/');
                    mkdir('./CAPA/'.$idDocente.'/');

                    copy('./assets/imgs/capa.png','./CAPA/'.$idDocente.'/capa.png');
                    copy('./assets/imgs/user.png','./FOTOS/'.$idDocente.'/user.png');

                    email("BEM - VINDO ao LEARN!",$email,"<img src='https://s3.us-east-2.amazonaws.com/porthosstorage1/bem-vindo.jpg'>");
                }
            }
			
    //    if(isset($_POST['acao']) && $_POST['acao'] == 'Enviar'){
		/*$de = 'porthos.soft@gmail.com';
		$msg = 'Olá você acabou de se cadastrar no Porthos Learn!';
		
		if(!empty($email) && !empty($msg)){
			$msg = wordwrap($msg, 70,"<br>", true);
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Equipe Porthos Learn <'.$de.'>' . "\r\n";
			mail($email,'Bem-Vindo ao Porthos Learn',$msg,$headers);
		}*/
	 //}


	} else if(mysqli_error($link) == "Duplicate entry '".$email."' for key 'EMAIL'") {
        header('Location: inscrevase.php?erro=1');
    } else if(mysqli_error($link) == "Duplicate entry '".$login."' for key 'LOGIN'") {
        header('Location: inscrevase.php?erro=2');
	} else {
        header('Location: inscrevase.php?erro=3');
        }
?>