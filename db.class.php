<?php

class db {
	private $host = 'localhost';
	private $usuario = 'PORTHOS';
	private $senha = 'P0rth0s3#';
	private $database = 'porthos';

	public function conecta_mysql(){
		$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
		mysqli_set_charset($con, 'utf8');
		if(mysqli_connect_errno()){
			echo 'Erro ao tentar se conectar com o BD MySQL: '.mysqli_connect_error();	
		}
		return $con;
	}
}

?>