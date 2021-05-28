<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 21/10/2017
 * Time: 22:58
 */

require_once ('db.class.php');
//include('nFuncoes.php');
require_once ('functions.php');

class Docente{
    private $id;
    private $nome = "";
    private $login;
    private $dataNascimento;
    private $genero;
    private $dataCadastro;
    private $resumo;
    private $foto;

    function retNomeDocente($id){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sqlRetNome = "select d.id, d.nome
                           from docente as d
                           where d.ID = $id";

        $nomeDocente = mysqli_query($link, $sqlRetNome);

        if($nomeDocente){
            $carregaNome = mysqli_fetch_array($nomeDocente);

            if(isset($carregaNome['nome'])){
                return $this.$nome=$carregaNome['nome'];
            }else{
                echo 'Problema para exibir o nome...';
            }
        }
    }


}