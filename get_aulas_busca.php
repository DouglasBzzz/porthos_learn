<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: index.php?erro=1');
}

require_once('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');

$interesse = addslashes($_POST['nome_docente']);
$iddocente = $_SESSION['id'];

$objdb = new db();
$link = $objdb->conecta_mysql();

$sqlAulasSeguidos = "select distinct a.id as idAula, a.TITLE, a.DESCCONTEUDO, d.NOME, 
                    date_format(a.DATAINCLUSAO,'%d %b %Y') as datainclusao, 
                    d.nome as docente, d2.ID as idDocenteSeguido 
                    from aulainteresses as ai 
                    inner join interesse as i on i.id = ai.IDINTERESSE 
                    inner join aula as a on a.ID = ai.IDAULA 
                    inner join docente as d on d.ID = a.IDDOCENTE 
                    left join seguidores as s on s.idseguido = a.iddocente 
                    left join docente as d1 on d.id = s.idseguidor 
                    inner join docente as d2 on d2.id = s.idseguido 
                    where ((a.PUBLICA = 1 and d.SITUACAO = 1 and i.DESCRICAO like '%$interesse%')
                    or(a.publica = 1 and d.situacao = 1 and a.DESCCONTEUDO like '%$interesse%')
                    or(a.publica = 1 and d.situacao = 1 and a.title like '%$interesse%'))and d.ID <> $iddocente;";

$resultadoSeguidosId = mysqli_query($link, $sqlAulasSeguidos);
if ($resultadoSeguidosId) {
    gravaPesquisa($iddocente,$interesse);
    if(mysqli_num_rows($resultadoSeguidosId) > 0){
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
    }else{
        echo 'Não há registro de <strong>AULAS</strong> para sua busca';
    }
    //$_SESSION['idAula'] = $registroSeguidos['idAula'];
} else {
    echo 'Ops! Tivemos um problema para recuperar as aulas dos usuários que você acompanha. Por favor, entre em contato com a Porthos.';
    echo '<br/>';
    echo $sqlAulasSeguidos;
}
?>