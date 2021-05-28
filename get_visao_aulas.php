<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header('Location: index.php?erro=1');
    }

    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    $idAula = $_POST['idAula'];
    $iddocente = $_SESSION['id'];

    $objdb = new db();
    $link = $objdb ->conecta_mysql();

    $sqlDadosAula = "SELECT DISTINCT a.ID, a.TITLE, a.DESCCONTEUDO, date_format(a.DATAINCLUSAO,'%d %b %Y') as datainclusao,
                    a.IDDOCENTE, d.nome, f.descricao, ta.descricao, a.NALUNOSIDEAL, 
                    case
                        when a.LINKWEB = '' or a.LINKWEB is null then 'Não existe link externo para essa atividade.'
                    end as linkAtv
                    from aula as a 
                    inner join docente as d on d.ID = a.IDDOCENTE
                    inner join seguidores as s on s.IDSEGUIDO = a.IDDOCENTE
                    inner join tipoaula as ta on ta.id = a.IDTIPOAULA
                    inner join faixaetaria as f on f.ID = a.IDFAIXAETARIARECOMENDADA
                    where s.IDSEGUIDOR = $iddocente and a.ID = $idAula";
    /*echo $sqlDadosAula;
    echo '<br/>';
    echo $idAula;
    echo '<br/>';
    echo $iddocente; */


    $resultado = mysqli_query($link,$sqlDadosAula);

    if ($resultado){
        while ($registroAula = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
            echo'<form>';

                echo'<div class="post">';

                    echo '<a href="#">'.$registroAula['TITLE'].'</a>';

                echo'</div>';

            echo '</form>';
        }
    }

?>