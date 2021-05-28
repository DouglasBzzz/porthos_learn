<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 30/12/2017
 * Time: 13:47
 */

    session_start();
    require_once ('db.class.php');
    include ('nFuncoes.php');

    if(isset($_POST['txtAssunto']) && $_POST['txtAssunto']<>''){
        $assunto = addslashes($_POST['txtAssunto']);
    }

    if(isset($_POST['txtConteudo']) && $_POST['txtConteudo']<>''){
        $conteudo = $_POST['txtConteudo'];
    }

    if(isset($_POST['txtFiltro']) && $_POST['txtFiltro']<>''){
        $filtro = $_POST['txtFiltro'];
    }

    if(!isset($assunto) || !isset($conteudo)){
        echo 'Não vou mandar o e-mail. Existem informações erradas! Verifique';
    }else{
        try{

            $objDb = new db();
            $link= $objDb->conecta_mysql();

            if(isset($filtro)){
                $sql = "$filtro";
            }else{
                $sql = "select d.nome, d.email
                        from docente as d
                        where d.situacao = 1 and d.recebenotificacao = 1 and email <>''";
            }

            $execSql = mysqli_query($link, $sql);

            if($execSql){
                while($mandaEmail = mysqli_fetch_array($execSql,MYSQLI_ASSOC)){
                    email("$assunto",$mandaEmail['email'],"$conteudo");
                    sleep(1);
                }
            }else{
                echo "#Erro ao recuperar os registros# - Verifique sua instrução SQL ";
            }

        }catch (Exception $e){
            echo $e->getMessage();
        }finally{
            echo "<hr>";
            echo "<h3><label>Feito!</label></h3>";
            echo "<br/>";
            echo "<h3><label><a href=\"emailMKT.php\">Voltar para o E-mail</a></label></h3>";
        }
    }





?>