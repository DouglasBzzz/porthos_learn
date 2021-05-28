<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 08/09/2017
 * Time: 18:40
 */

    session_start();

    if(!isset($_SESSION['login'])){
        header('Location: profile.php');
    }
    require_once ('db.class.php');
    require_once ('functions.php');

    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $idDocente = $_SESSION['id'];
    $idAula = $_POST['idAula'];

    //echo $idAula;

    if(isset($_POST['title']) && $_POST['title']<>''){
        $titulo = addslashes($_POST['title']);
    }

    if(isset($_POST['descConteudo']) && $_POST['descConteudo']<>''){
        $descConteudo = addslashes($_POST['descConteudo']);
    }

    if(isset($_POST['nAlunosIdeal']) && $_POST['nAlunosIdeal']<>''){
        $nAlunosIdeal = $_POST['nAlunosIdeal'];
    }

    if(isset($_POST['linkAtvWeb']) && $_POST['linkAtvWeb']<>''){
        $linkWeb = addslashes($_POST['linkAtvWeb']);
    }

    if(isset($_POST['editor1']) && $_POST['editor1']<>''){
        $conteudo = addslashes($_POST['editor1']);
    }

    $publica = $_POST['publica'];

    $tpAula = $_POST['tipoAula'];

    $faixaEtaria = $_POST['faixaEtaria'];

    $dadosEmBanco = "SELECT DISTINCT a.ID, a.TITLE, a.DESCCONTEUDO, 
                            date_format(a.DATAINCLUSAO,'%d %b %Y') as datainclusao,
                            a.IDDOCENTE, d.nome, f.ID as idFaixa, f.descricao as descricaoFaixa, 
                            ta.ID as idTpAula, ta.descricao as descricaoTpAula, 
                            a.NALUNOSIDEAL, a.DESCRICAO, a.PUBLICA,
                            case
                            when a.LINKWEB = '' or a.LINKWEB is null then 'Não existe link externo para essa atividade.'
                            else a.LINKWEB
                            end as linkAtv
                            from aula as a 
                            inner join docente as d on d.ID = a.IDDOCENTE
                            inner join seguidores as s on s.IDSEGUIDO = a.IDDOCENTE
                            inner join tipoaula as ta on ta.id = a.IDTIPOAULA
                            inner join faixaetaria as f on f.ID = a.IDFAIXAETARIARECOMENDADA
                            where a.ID = $idAula";

    if($dadosCarregados = mysqli_query($link, $dadosEmBanco)){

        header("Location: docenteVisaoAula.php?idAula=$idAula");

        $dadosAula = mysqli_fetch_array($dadosCarregados);

        if(($dadosAula['TITLE'])<>$titulo){
            $sqlUpdateAulaTitulo = "update aula set TITLE = '$titulo' where ID = $idAula";
            $updateAulaTitulo = mysqli_query($link,$sqlUpdateAulaTitulo);
            if($updateAulaTitulo){
                echo 'Titulo alterado com sucesso...</br>';
            }else{
                echo 'cai em titulo, e deu problema...</br>';
            }
        }

        if(($dadosAula['DESCCONTEUDO']) <> $descConteudo){
            $sqlUpdateAulaDesConteudo = "update aula set DESCCONTEUDO = '$descConteudo' where ID = $idAula";
            $updateAulaDesConteudo = mysqli_query($link, $sqlUpdateAulaDesConteudo);
            if($updateAulaDesConteudo){
                echo 'descricao breve alterada com sucesso...</br>';
            }else{
                echo 'cai na edicao de descricao breve, mas tive problema...</br>';
            }
        }

        if(($dadosAula['NALUNOSIDEAL'])<>$nAlunosIdeal){
            $sqlUpdateAulaNAlunos = "update aula set NALUNOSIDEAL = $nAlunosIdeal where ID = $idAula";
            $updateAulaNAlunos = mysqli_query($link, $sqlUpdateAulaNAlunos);
            if($updateAulaNAlunos){
                echo 'nAlunos alterado com sucesso... </br>';
            }else{
                echo 'cai no nAlunos alterado mas nao deu boa...</br>';
            }
        }

        if(($dadosAula['DESCRICAO'])<>$conteudo){
            $sqlUpdateDescricao = "update aula set DESCRICAO = '$conteudo' where id=$idAula";
            $updateDescricao = mysqli_query($link, $sqlUpdateDescricao);
            if($updateDescricao){
                echo 'CONTEUDO PRINCIPAL alterado com sucesso...</br>';
            }else{
                echo 'cai no conteudo principal, e nao alterei...</br>';
            }
        }

        if(($dadosAula['linkAtv'])<>$linkWeb){
            $sqlUpdateLink = "update aula set LINKWEB = '$linkWeb' where ID = $idAula";
            $updateLink = mysqli_query($link, $sqlUpdateLink);
            if($updateLink){
                echo 'link web alterado com sucesso...</br>';
            }else{
                echo 'cai no link, mas deu ruim...</br>';
            }
        }

        if(($dadosAula['PUBLICA'])<>$publica){
            $sqlUpdatePublica = "update aula set PUBLICA = $publica where ID = $idAula";
            $updatePublica = mysqli_query($link,$sqlUpdatePublica);
            if($updatePublica){
                echo 'ok, alterei o status publico da aula...</br>';
            }else{
                echo 'cai na edicao do publico...</br>';
            }
        }

        if(($dadosAula['idTpAula'])<>$tpAula){
            $sqlUpdateTpAula = "update aula set IDTIPOAULA = $tpAula where ID = $idAula";
            $updateTpAula = mysqli_query($link, $sqlUpdateTpAula);
            if($updateTpAula){
                echo 'ok, alterei o tp aula...</br>';
            }else{
                echo 'cai na alteracao de tpAula, deu ruim... </br>';
            }
        }

        if(($dadosAula['idFaixa'])<>$faixaEtaria){
            $sqlUpdateFaixa = "update aula set IDFAIXAETARIARECOMENDADA = $faixaEtaria where ID = $idAula";
            $updateFaixa = mysqli_query($link, $sqlUpdateFaixa);
            if($updateFaixa){
                echo 'ok, alterei a faixa etaria...</br>';
            }else{
                echo 'cai na alteracao de faixa etaria, deu ruim...</br>';
            }
        }
    }

?>