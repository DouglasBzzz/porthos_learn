<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: index.php?erro=1');
}

require_once('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');

$iddocente = $_SESSION['id'];

$objdb = new db();
$link = $objdb->conecta_mysql();

$sqlAulasSeguidos = "select d2.id as idDocenteSeguido, d2.NOME, a.id as idAula, a.TITLE, a.DESCCONTEUDO, 
                     date_format(a.DATAINCLUSAO,'%d %b %Y %T') as datainclusao
                     from aula as a 
                     inner join seguidores as s on s.idseguido = a.iddocente
                     inner join docente as d on d.id = s.idseguidor
                     inner join docente as d2 on d2.id = s.idseguido
                     where (d.id = $iddocente and d.SITUACAO = 1) and s.DATADEIXOUDESEGUIR is null and a.PUBLICA = 1
                     order by a.datainclusao DESC ";

$resultadoSeguidosId = mysqli_query($link, $sqlAulasSeguidos);
if ($resultadoSeguidosId) {
    while ($registroSeguidos = mysqli_fetch_array($resultadoSeguidosId, MYSQLI_ASSOC)) {
        $_SESSION['idAula'] = $registroSeguidos['idAula']; //seta IdAula na sessao > byDouglas em 11/07
        $nComentarios = new functions();
        //$nComentarios ->retNcomentariosAula($registroSeguidos['idAula']);

        //echo $nComentariosAula;
        //echo $_SESSION['idAula'];
        echo '<form action="verAula.php" method="get">
                    <div class="post">
                        <div class="user-block">
                            <div class="img-circle img-bordered-sm"
                                style="background: url('.retFoto($registroSeguidos['idDocenteSeguido']).') center">
                                <span class="username">
                                    <a href="verPerfil.php?idDocente='.$registroSeguidos['idDocenteSeguido'].'">' . $registroSeguidos['NOME'] . '</a>
                                </span>
                                <span class="description">' . $registroSeguidos['datainclusao'] . '</span>
                                    <input type="hidden" value="' . $registroSeguidos['idAula'] . '" name="idAula"/>
                            </div>
                        </div>
                        <h4><p>' . $registroSeguidos['TITLE'] . '</p> </h4>
                        <p>' . $registroSeguidos['DESCCONTEUDO'] . '</p>
                        <ul class="list-inline">
                            <li>
                                <button type="submit" class="btn btn-xs"><i class="fa fa-eye"></i> Visualizar</button>
                            </li>
                            <li>';
                                echo'<button type="button" class="btn btn-xs"><i class="fa fa-comments-o">'.$nComentarios->retNcomentariosAula($registroSeguidos['idAula']).'</i></button>
                            </li>
                        </ul>
                    </div>
            </form>';
    }
    //$_SESSION['idAula'] = $registroSeguidos['idAula'];
} else {
    echo 'Ops! Tivemos um problema para recuperar as aulas dos usuários que você acompanha. Por favor, entre em contato com a Porthos.';
}
?>