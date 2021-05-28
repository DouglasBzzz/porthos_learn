<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 18/08/2017
 * Time: 20:38
 */

    session_start();

    require_once ('db.class.php');
    require_once ('functions.php');
    include ('nFuncoes.php');

    /*IMPLEMENTAR CHAMADA DE DADOS DO CADASTRO DE DOCENTE*/

    $iddocente = $_SESSION['id'];

    if(isset($_POST['nome'])&&$_POST['nome']<>''){
        $nome = addslashes($_POST['nome']);
    }

    if(isset($_POST['senha']) && $_POST['senha']<>'' && $_POST['senha']<>' ') {
        $senha = md5($_POST['senha']);
    }

    $email = addslashes($_POST['email']);
    $sobre = addslashes($_POST['about']);
    //$dataNascimento = date('Y-m-d H:i:s', strtotime($_POST['dataNascimento']));//precisa mudar isso aqui...byDouglas

    $cell = addslashes($_POST['cell']);
    $instituicao = addslashes($_POST['instituicao']);

    $idCidade = $_POST['inputCidade'];
    $idGrauInstrucao = $_POST['inputFormacao'];

    $genero = $_POST['radioGenero'];

    //interessesDocente...

    $nascimentoPublica = $_POST['checkDtNascPublica'];
    $recebeNotificacaoAula = $_POST['checkNotificacaoNovaAula'];
    $recebeNotificacaoComentario = $_POST['checkNotificacaoComentario'];
    $recebeNotificacaoAvaliacao = $_POST['checkNotificacaoAvaliacao'];
    $recebeNotificacaoSeguidor = $_POST['checkNotificacaoSeguidores'];

    if(isset($_POST['lattes'])&&$_POST['lattes']<>''){
        $linkLattes = addslashes($_POST['lattes']);
    }


    //echo $dataNascimento;

    //levanta os dados do usuário logado com base no jah gravado em banco. byDouglas em 22/08
    $objdb = new db();
    $link = $objdb->conecta_mysql();

    $dadosEmBanco = "select d.id, d.nome, d.SENHA, d.datanascimento, d.genero, d.datanascimentopublica, d.RECEBENOTIFICACAO ,d.email,
                     d.cell, d.resumo, d.instituicao, d.idcidade, d.IDGRAUINSTRUCAO, d.LATTES, dc.notificacaoaula, dc.notificacaocomentario, dc.notificacaoseguidor, dc.notificacaoavaliacao 
                     from docente as d
                     left join docenteconfig as dc on dc.iddocente = d.id
                     where d.ID=$iddocente";

    $dadosInteresse = "select di.IDDOCENTE, d.nome, di.IDINTERESSE, i.descricao
                       from docenteinteresses as di
                       inner join docente as d on d.ID = di.IDDOCENTE
                       inner join interesse as i on i.ID = di.IDINTERESSE
                       where di.IDDOCENTE = $iddocente";

    $dadosCarregados = mysqli_query($link, $dadosEmBanco);
    $dadosInteresseCarregados = mysqli_query($link, $dadosInteresse);

    $sqlLastUpdate = "update docente set DATALASTEDICAO = '".retDataHora()."' where ID = $iddocente";
    $updateLastUpdate = mysqli_query($link, $sqlLastUpdate);
    if($updateLastUpdate){
        echo 'ok, atualizada data de atualziação...';
        header('Location: profile.php');
    }else{
        echo 'caí na alteração de dataEdicao, mas tive problemas... ';
    }

    if ($dadosCarregados){
        $dadosDocente = mysqli_fetch_array($dadosCarregados);

        //nome
        if (($dadosDocente['nome']) <> $nome){
            $sqlUpdateNome = "update docente set NOME = '$nome' where ID = $iddocente";
            $updateDocenteNome = mysqli_query($link,$sqlUpdateNome);
            if ($updateDocenteNome){
                echo 'nome alterado com sucesso<br/>';
            }else{
                echo 'caí na edição de nome, mas tive problema pra gravar...<br/>';
            }
        }
        //senha
        if (isset($senha)) {
            if (($dadosDocente['SENHA']) <> $senha) {
                $sqlUpdateDocenteSenha = "update docente set SENHA = '$senha' where ID = $iddocente";
                $updateDocenteSenha = mysqli_query($link, $sqlUpdateDocenteSenha);
                if ($updateDocenteSenha) {
                    echo 'senha alterada com sucesso<br/>';
                } else {
                    echo 'caí na edição de senha, mas tive problema para gravar...<br/>';
                }
            } else {
                echo 'senha invalida...';
            }
        }
        //dataNascimento
        /*if (($dadosDocente['datanascimento'])<>$dataNascimento){
            $sqlUpdateDataNascimento = "update docente set DATANASCIMENTO = '$dataNascimento' where id=$iddocente";
            $updateDocenteDataNascimento = mysqli_query($link,$sqlUpdateDataNascimento);
            if ($sqlUpdateDataNascimento){
                echo 'dataNascimento alterado com sucesso<br/>';
            }else{
                echo 'caí na edicao de dataNascimento, mas tive problemas para gravar...<br/>';
            }
        }*/
        //genero
        if (($dadosDocente['genero'])<>$genero){
            $sqlUpdateGenero = "update docente set GENERO = $genero WHERE id = $iddocente";
            $updateDocenteGenero = mysqli_query($link,$sqlUpdateGenero);
            if ($updateDocenteGenero){
                echo 'genero alterado com sucesso...<br/>';
            }else{
                echo 'caí na alteracao de genero, mas tive problemas para gravar...<br/>';
            }
        }
        //dataNascimentoPublica
        if (($dadosDocente['datanascimentopublica'])<>$nascimentoPublica){
            $sqlUpdateNascimentoPublico = "update docente set DATANASCIMENTOPUBLICA = $nascimentoPublica where id = $iddocente";
            $updateNascimentoPublico = mysqli_query($link, $sqlUpdateNascimentoPublico);
            if ($updateNascimentoPublico){
                echo 'dataNascimentoPublica alterada com sucesso...<br/>';
            }else{
                echo 'caí na alteracao de dataNascimentoPublica, mas tive problemas para gravar...<br/>';
            }
        }
        //email
        if (($dadosDocente['email'])<>$email){
            $sqlUpdateDocenteEmail = "update docente set EMAIL = '$email' where ID = $iddocente";
            $updateDocenteEmail = mysqli_query($link, $sqlUpdateDocenteEmail);
            if($updateDocenteEmail){
                echo 'email alterado com sucesso...<br/>';
            }else{
                echo 'caí na alteracao de email, mas tive problemas para gravar...<br/>';
            }
        }
        //cell
        if (($dadosDocente['cell'])<>$cell){
            $sqlUpdateDocenteCell = "update docente set CELL = '$cell' where id = $iddocente";
            $updateDocenteCell=mysqli_query($link,$sqlUpdateDocenteCell);
            if($updateDocenteCell){
                echo 'cell alterado com sucesso...<br/>';
            }else{
                echo 'caí na alteracao de cell, mas tive problemas para gravar...<br/>';
            }
        }
        //sobre
        if (($dadosDocente['resumo'])<>$sobre){
            $sqlUpdateDocenteSobre = "update docente set RESUMO = '$sobre' where ID = $iddocente";
            $updateDocenteSobre = mysqli_query($link, $sqlUpdateDocenteSobre);
            if($updateDocenteSobre){
                echo 'sobre alterado com sucesso...<br/>';
            }else{
                echo 'caí na alteracao de sobre, mas tive problema pra gravar...<br/>';
            }

        }
        //instituicao
        if(($dadosDocente['instituicao'])<>$instituicao){
            $sqlUpdateDocenteInstituicao = "update docente set INSTITUICAO = '$instituicao' where id = $iddocente";
            $updateDocenteInstituicao = mysqli_query($link, $sqlUpdateDocenteInstituicao);
            if($updateDocenteInstituicao){
                echo 'instituicao alterada com sucesso...<br/>';
            }else{
                echo 'caí na alteração de instituicacao, porem tive problema pra gravar...<br/>';
            }
        }
        //grauInstrucao
        if(($dadosDocente['IDGRAUINSTRUCAO'])<>$idGrauInstrucao){
            $sqlUpdateDocenteGrauInstrucao = "update docente set IDGRAUINSTRUCAO = $idGrauInstrucao WHERE ID = $iddocente";
            $updateDocenteGrauInstrucao = mysqli_query($link, $sqlUpdateDocenteGrauInstrucao);
            if($updateDocenteGrauInstrucao){
                echo 'grauINSTRUCAO alterado com sucesso...<br/>';
            }else{
                echo 'caí na alteração do grauINSTRUCAO, mas tive problemas...<br/>';
            }
        }
        //cidade
        if(($dadosDocente['idcidade'])<>$idCidade){
            $sqlUpdateDocenteCidade = "update docente set IDCIDADE = $idCidade where ID = $iddocente";
            $updateDocenteCidade = mysqli_query($link, $sqlUpdateDocenteCidade);
            if($updateDocenteCidade){
                echo 'cidade alterada com sucesso...<br/>';
            }else{
                echo 'caí na cidade, mas tive problemas...<br/>';
            }
        }
        //notificaoes e nascimento
        /*if(($dadosDocente['RECEBENOTIFICACAO'])<>$recebeNotificacoes){
            $sqlRecebeNotificacoes = "update docente set RECEBENOTIFICACAO = $recebeNotificacoes where ID = $iddocente";
            $updateDocenteResNot = mysqli_query($link,$sqlRecebeNotificacoes);
            if($updateDocenteResNot){
                echo 'agora todos podem ver sua data de nascimento...<br/>';
            }else{
                echo 'caí na alteracao de dtnascimentopublica, mas tive problema pra gravar...<br/>';
            }
        }*/
        //lattes
        if(isset($_POST['lattes'])){
            if($dadosDocente['LATTES']<>$linkLattes){
                $sqlLattes = "update docente set LATTES = '$linkLattes' where ID = $iddocente";
                $updateDocenteLattes = mysqli_query($link,$sqlLattes);
                if($updateDocenteLattes){
                    echo 'agora há um lattes associado...<br/>';
                }else{
                    echo 'caí na alteracao do lattes, mas tive problemas para gravar...<br/>';
                }
            }
        }

        //notificacao novas aulas
        if(($dadosDocente['notificacaoaula'])<>$recebeNotificacaoAula){
            $sqlRecebeNotificacaoNovasAulas = "update docenteconfig set notificacaoaula = $recebeNotificacaoAula where iddocente = $iddocente";
            $updateDocenteNotificacoesAula = mysqli_query($link, $sqlRecebeNotificacaoNovasAulas);
            if($updateDocenteNotificacoesAula){
                echo "agora voce recebe as notificacoes das aulas novas...<br/>";
            }else{
                echo "caí na alteração de notificações de novas aulas e tive problema pra gravar...<br/>";
            }
        }
        //notificacao novos comentarios
        if(($dadosDocente['notificacaocomentario'])<>$recebeNotificacaoComentario){
            $sqlRecebeNotificacaoComentarios = "update docenteconfig set notificacaocomentario = $recebeNotificacaoComentario where iddocente = $iddocente";
            $updateDocenteNotificacoesComentarios = mysqli_query($link, $sqlRecebeNotificacaoComentarios);
            if($updateDocenteNotificacoesComentarios){
                echo "agora voce recebe as notificacoes de novos comentários...<br/>";
            }else{
                echo "caí na alteração de notificações de novos comentários e não deu certo...<br/>";
            }
        }
        //notificacoes novas avaliacoes
        if(($dadosDocente['notificacaoavaliacao'])<>$recebeNotificacaoAvaliacao){
            $sqlRecebeNotificacaoAvaliacao = "update docenteconfig set notificacaoavaliacao = $recebeNotificacaoAvaliacao where iddocente = $iddocente";
            $updateDocenteNotificacoesAvaliacao = mysqli_query($link, $sqlRecebeNotificacaoAvaliacao);
            if($updateDocenteNotificacoesAvaliacao){
                echo "agora voce recebe as notificacoes de Novas Avaliações...<br/>";
            }else{
                echo "caí na alteração de notificações de Novas Avaliações e não deu certo...<br/>";
            }
        }
        //notificacoes de novos seguidores
        if(($dadosDocente['notificacaoseguidor'])<>$recebeNotificacaoSeguidor){
            $sqlRecebeNotificacaoSeguidor = "update docenteconfig set notificacaoseguidor = $recebeNotificacaoSeguidor where iddocente = $iddocente";
            $updateDocenteNotificacoesSeguidor = mysqli_query($link, $sqlRecebeNotificacaoSeguidor);
            if($updateDocenteNotificacoesSeguidor){
                echo "agora voce recebe as notificacoes de novos seguidores...<br/>";
            }else{
                echo "caí na alteração de notificações de novos seguidores e não deu certo...<br/>";
            }
        }

        //interesses

        if(isset($_POST['listInteresses'])){
            $listaDeInteresses = $_POST['listInteresses'];

            $sqlInsertInteresses = "insert into docenteinteresses VALUES ";
            foreach ($listaDeInteresses as $interesse){
                $idInteresse = $interesse;
                $sqlInsertInteresses .= "(null, $iddocente, {$idInteresse}),";
            }
            $sqlInsertInteresses = substr($sqlInsertInteresses,0,-1);
            if (mysqli_query($link, $sqlInsertInteresses)) {
                echo '<br/>CRIAR REGISTRO EM docenteinteresses - > OK<br/>';
            } else {
                echo 'CRIAR REGISTRO EM docenteInteresses - > NAO GRAVOU';
                echo '</br>';
            }

        }


        /*if($dadosInteresseCarregados){
            $listInteressesDocente = mysqli_fetch_array($dadosInteresseCarregados);
            if(isset($listInteressesDocente['IDDOCENTE']) && isset($listInteressesDocente['IDINTERESSE'])){
                foreach ($listInteressesDocente['IDINTERESSE'] as $interesse){
                    if()
                }
            }
        }*/
    }

    /*$sqlLastUpdate = "update docente set DATALASTEDICAO = now() where ID = $iddocente";
    $updateLastUpdate = mysqli_query($link, $sqlLastUpdate);
    if($updateLastUpdate){
        echo 'ok, atualizada data de atualziação...';
    }else{
        echo 'caí na alteração de dataEdicao, mas tive problemas... ';
    }*/

?>