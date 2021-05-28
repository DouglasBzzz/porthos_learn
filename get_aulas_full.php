<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 01/02/2018
 * Time: 11:26
 */

    session_start();

    if(!isset($_SESSION['login'])){
        header('Location: index.php?erro=1');
    }

    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    $idDocenteSessao = $_SESSION['id'];

    $objdb = new db();
    $link = $objdb ->conecta_mysql();

    $sql = "select distinct d.id as iddocente, d.nome, date_format(a.datainclusao, '%d %b %Y %T') as dataInclusao, a.id as idAula, a.title, a.descconteudo
            from aula as a
            inner join docente as d on d.id = a.iddocente
            where a.iddocente = $idDocenteSessao and d.situacao = 1
            union
            select distinct d2.id as iddocente, d2.nome, date_format(a1.datainclusao,'%d %b %Y %T') as dataInclusao, a1.id as idAula, a1.title, a1.descconteudo
            from aula as a1
            inner join seguidores as s on s.idseguido = a1.iddocente
            inner join docente as d1 on d1.id = s.idseguidor
            inner join docente as d2 on d2.id = s.idseguido
            where (d1.id = $idDocenteSessao and d1.situacao = 1) and s.datadeixoudeseguir is null and a1.publica = 1
            order by idAula desc";

    try{

        $resultadoConsulta = mysqli_query($link,$sql);

        if($resultadoConsulta){
            while($registro = mysqli_fetch_array($resultadoConsulta, MYSQLI_ASSOC)){
                $_SESSION['idAula']=$registro['idAula'];
                $nComentariosAula = new functions();

                //valida se o usuario resultante da consulta eh o da sessao. se for, aponta pra um tipo de visualização, do contrario, aponta pra padrao. byDouglas

                if ($registro['iddocente']==$idDocenteSessao){
                    echo '<form action="docenteVisaoAula.php" method="get">';
                }else{
                    echo '<form action="verAula.php" method="get">';
                }
                echo '
                <div class="post">
                    <div class="user-block">
                        <div class="img-circle img-bordered-sm"
                             style="background: url('.retFoto($registro['iddocente']).') center">
                            <span class="username">
                                <a href="verPerfil.php?idDocente='.$registro['iddocente'].'">'.$registro['nome'].'</a>
                            </span>
                            <span class="description">'.$registro['dataInclusao'].'</span>
                            <input type="hidden" value="' . $registro['idAula'] . '" name="idAula"/>
                        </div>
                    </div>
                    <h4><p>'.$registro['title'].'</p> </h4>
                    <p>'.$registro['descconteudo'].'</p>
                    <ul class="list-inline">
                        <li>
                            <button type="submit" class="btn btn-xs"><i class="fa fa-eye"></i> Visualizar</button>
                        </li>
                        <li>';
                echo '<button type="submit" class="btn btn-xs"><i class="fa fa-comments-o"></i>'.$nComentariosAula->retNcomentariosAula($registro['idAula']).'</button>
                        </li>
                    </ul>
                </div>
            </form>';
            }
        }

    }catch (Exception $e){
        echo "Ouve um erro para recuperar as aulas...: ".$e->getMessage();
    }

?>