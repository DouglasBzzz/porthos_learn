<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header('Location: index.php?erro=1');
    }

    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    $iddocente = $_SESSION['id'];

    $objdb = new db();
    $link = $objdb ->conecta_mysql();

    $sql = "Select d.LOGIN,d.nome, date_format(a.DATAINCLUSAO,'%d %b %Y %T') as DATAINCLUSAO, a.ID as idAula,a.TITLE, a.DESCCONTEUDO 
            from aula as a 
            inner join docente as d 
            on d.ID = a.IDDOCENTE 
            where a.IDDOCENTE = $iddocente and d.SITUACAO = 1
            order by a.DATAINCLUSAO DESC";

    $resultadoid = mysqli_query($link, $sql);
    if($resultadoid){
        while($registro = mysqli_fetch_array($resultadoid, MYSQLI_ASSOC)){
            $_SESSION['idAula'] = $registro['idAula'];
            $nComentariosAula = new functions();
            //$nComentariosAula->retNcomentariosAula($_SESSION['idAula']);

            echo '<form action="docenteVisaoAula.php" method="get">
                <div class="post">
                    <div class="user-block">
                        <div class="img-circle img-bordered-sm"
                             style="background: url('.retFoto($_SESSION['id']).') center">
                            <span class="username">
                                <a href="verPerfil.php?idDocente='.$iddocente.'">'.$registro['nome'].'</a>
                            </span>
                            <span class="description">'.$registro['DATAINCLUSAO'].'</span>
                            <input type="hidden" value="' . $registro['idAula'] . '" name="idAula"/>
                        </div>
                    </div>
                    <h4><p>'.$registro['TITLE'].'</p> </h4>
                    <p>'.$registro['DESCCONTEUDO'].'</p>
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
    }else{
        echo 'Ops! Tivemos um problema para recuperar as suas aulas. Por favor, entre em contato com a porthos.';
    }
?>
